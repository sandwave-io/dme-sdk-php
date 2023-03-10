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
 * @property-read array                $activeThirdParties
 * @property-read \DateTime            $created
 * @property-read \DateTime            $updated
 * @property bool $gtdEnabled
 * @property-read string[]             $axfrServers
 * @property-read string[]             $delegateNameServers
 * @property-read object[]             $nameServers
 * @property SOARecordInterface        $soa;
 * @property int                       $soaID
 * @property VanityNameServerInterface $vanity
 * @property int                       $vanityId
 * @property TransferAcl               $transferAcl
 * @property int                       $transferAclId
 * @property FolderInterface           $folder
 * @property int                       $folderId
 * @property TemplateInterface         $template
 * @property int                       $templateId
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
     */
    protected ?DomainRecordManagerInterface $recordManager = null;

    /**
     * @internal
     */
    public function transformForApi(): object
    {
        // Get the default API conversion
        $payload = parent::transformForApi();

        // We can't update these
        $payload->updated = $this->apiData?->updated ?? null;
        $payload->created = $this->apiData?->created ?? null;

        return $payload;
    }

    /**
     * Sets the folder for domain.
     */
    protected function setFolder(mixed $folder): void
    {
        if (is_integer($folder)) {
            $this->folderId = $folder;
        } elseif ($folder instanceof CommonFolderInterface) {
            $this->folderId = $folder->id;
        }
    }

    /**
     * Sets the Vanity Nameserver for the domain.
     */
    protected function setVanity(mixed $vanity): void
    {
        if (is_integer($vanity)) {
            $this->vanityId = $vanity;
        } elseif ($vanity instanceof VanityNameServerInterface) {
            $this->vanityId = $vanity->id;
        }
    }

    /**
     * Sets the Transfer ACL for the domain.
     */
    protected function setTransferAcl(mixed $transferAcl): void
    {
        if (is_integer($transferAcl)) {
            $this->transferAclId = $transferAcl;
        } elseif ($transferAcl instanceof TransferAclInterface) {
            $this->transferAclId = $transferAcl->id;
        }
    }

    /**
     * Sets the Template for the domain.
     */
    protected function setTemplate(mixed $template): void
    {
        if (is_integer($template)) {
            $this->templateId = $template;
        } elseif ($template instanceof TemplateInterface) {
            $this->templateId = $template->id;
        }
    }

    /**
     * Set the custom SOA Record for the domain.
     */
    protected function setSOA(mixed $soa): void
    {
        if (is_integer($soa)) {
            $this->soaID = $soa;
        } elseif ($soa instanceof SOARecordInterface) {
            $this->soaID = $soa->id;
        }
    }

    /**
     * Get the custom SOA record assigned to the domain.
     */
    protected function getSOA(): ?SOARecordInterface
    {
        if ($this->soaID === null) {
            return null;
        }
        return $this->client->soarecords->get($this->soaID);
    }

    /**
     * Get the Transfer ACL assigned to the domain.
     */
    protected function getTransferAcl(): ?TransferAclInterface
    {
        if ($this->transferAclId === null) {
            return null;
        }
        return $this->client->transferacls->get($this->transferAclId);
    }

    /**
     * Get the Vanity Nameserver assigned to the domain.
     */
    protected function getVanity(): ?VanityNameServerInterface
    {
        if ($this->vanityId === null) {
            return null;
        }
        return $this->client->vanity->get($this->vanityId);
    }

    /**
     * Sets the name of the domain. This can only be set on new domains.
     *
     * @throws ReadOnlyPropertyException
     */
    protected function setName(string $name): void
    {
        if ($this->id !== null) {
            throw new ReadOnlyPropertyException('Unable to set name because id is filled');
        }
        $this->props['name'] = $name;
    }

    /**
     * Gets the record manager for this domain.
     */
    protected function getRecords(): DomainRecordManagerInterface
    {
        if ($this->recordManager === null) {
            $this->recordManager = new DomainRecordManager($this->client);
            $this->recordManager->setDomain($this);
        }
        return $this->recordManager;
    }
}
