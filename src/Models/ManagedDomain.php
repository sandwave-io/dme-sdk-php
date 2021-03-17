<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Managers\DomainRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonFolderInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\SOARecordInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\TransferAclInterface;
use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;
use DnsMadeEasy\Managers\DomainRecordManager;
use DnsMadeEasy\Models\Common\CommonManagedDomain;

/**
 * Represents a Managed Domain resource.
 *
 * @package DnsMadeEasy\Models
 *
 * @property string $name
 * @property-read array $activeThirdParties
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property bool $gtdEnabled
 * @property-read string[] $axfrServers
 * @property-read string[] $delegateNameservers
 * @property SOARecordInterface $soa;
 * @property int $soaID
 * @property VanityNameServerInterface $vanity
 * @property int $vanityId
 * @property TransferAcl $transferAcl
 * @property int $transferAclId
 * @property FolderInterface $folder
 * @property int $folderId
 * @property TemplateInterface $template
 * @property int $templateId
 * @property-read DomainRecordManagerInterface $records
 */
class ManagedDomain extends CommonManagedDomain implements ManagedDomainInterface
{
    protected array $props = [
        'name' => null,
        'activeThirdParties' => [],
        'gtdEnabled' => null,
        'nameServers' => [],
        'soaID' => null,
        'templateId' => null,
        'vanityId' => null,
        'transferAclId' => null,
        'folderId' => null,
        'updated' => null,
        'created' => null,
        'axfrServer' => [],
        'delegateNameServers' => [],
    ];

    protected array $editable = [
        'gtdEnabled',
        'folderId',
        'vanityId',
        'transferAclId',
        'templateId',
    ];

    /**
     * The record manager for this domain.
     *
     * @var DomainRecordManagerInterface|null
     */
    protected ?DomainRecordManagerInterface $recordManager = null;

    /**
     * @return object
     *
     * @internal
     */
    public function transformForApi(): object
    {
        // Get the default API conversion
        $payload = parent::transformForApi();

        // We can't update these
        $payload->updated = $this->apiData ? $this->apiData->updated : null;
        $payload->created = $this->apiData ? $this->apiData->created : null;

        return $payload;
    }

    /**
     * Sets the folder for domain.
     *
     * @param $folder
     */
    protected function setFolder($folder)
    {
        if (is_integer($folder)) {
            $this->folderId = $folder;
        } elseif ($folder instanceof CommonFolderInterface) {
            $this->folderId = $folder->id;
        }
    }

    /**
     * Sets the Vanity Nameserver for the domain.
     *
     * @param $vanity
     */
    protected function setVanity($vanity)
    {
        if (is_integer($vanity)) {
            $this->vanityId = $vanity;
        } elseif ($vanity instanceof VanityNameServerInterface) {
            $this->vanityId = $vanity->id;
        }
    }

    /**
     * Sets the Transfer ACL for the domain.
     *
     * @param $transferAcl
     */
    protected function setTransferAcl($transferAcl)
    {
        if (is_integer($transferAcl)) {
            $this->transferAclId = $transferAcl;
        } elseif ($transferAcl instanceof TransferAclInterface) {
            $this->transferAclId = $transferAcl->id;
        }
    }

    /**
     * Sets the Template for the domain.
     *
     * @param $template
     */
    protected function setTemplate($template)
    {
        if (is_integer($template)) {
            $this->templateId = $template;
        } elseif ($template instanceof TemplateInterface) {
            $this->templateId = $template->id;
        }
    }

    /**
     * Set the custom SOA Record for the domain.
     *
     * @param $soa
     */
    protected function setSOA($soa)
    {
        if (is_integer($soa)) {
            $this->soaID = $soa;
        } elseif ($soa instanceof SOARecordInterface) {
            $this->soaID = $soa->id;
        }
    }

    /**
     * Get the custom SOA record assigned to the domain.
     *
     * @return SOARecordInterface|null
     */
    protected function getSOA(): ?SOARecordInterface
    {
        if (! $this->soaID) {
            return null;
        }
        return $this->client->soarecords->get($this->soaID);
    }

    /**
     * Get the Transfer ACL assigned to the domain.
     *
     * @return TransferAclInterface|null
     */
    protected function getTransferAcl(): ?TransferAclInterface
    {
        if (! $this->transferAclId) {
            return null;
        }
        return $this->client->transferacls->get($this->transferAclId);
    }

    /**
     * Get the Vanity Nameserver assigned to the domain.
     *
     * @return VanityNameServerInterface|null
     */
    protected function getVanity(): ?VanityNameServerInterface
    {
        if (! $this->vanityId) {
            return null;
        }
        return $this->client->vanity->get($this->vanityId);
    }

    /**
     * Sets the name of the domain. This can only be set on new domains.
     *
     * @param string $name
     *
     * @throws ReadOnlyPropertyException
     */
    protected function setName(string $name)
    {
        if ($this->id) {
            throw new ReadOnlyPropertyException('Unable to set name');
        }
        $this->props['name'] = $name;
    }

    /**
     * Gets the record manager for this domain.
     *
     * @return DomainRecordManagerInterface
     */
    protected function getRecords(): DomainRecordManagerInterface
    {
        if (! $this->recordManager) {
            $this->recordManager = new DomainRecordManager($this->client);
            $this->recordManager->setDomain($this);
        }
        return $this->recordManager;
    }
}
