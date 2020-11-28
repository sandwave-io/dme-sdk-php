<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Models\Common\CommonFolderInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\TransferAclInterface;
use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;
use DnsMadeEasy\Models\Common\CommonManagedDomain;

/**
 * @package DnsMadeEasy
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

    protected function setFolder($folder)
    {
        if (is_integer($folder)) {
            $this->folderId = $folder;
        } elseif ($folder instanceof CommonFolderInterface) {
            $this->folderId = $folder->id;
        }
    }

    protected function setVanity($vanity)
    {
        if (is_integer($vanity)) {
            $this->vanityId = $vanity;
        } elseif ($vanity instanceof VanityNameServerInterface) {
            $this->vanityId = $vanity->id;
        }
    }

    protected function setTransferAcl($transferAcl)
    {
        if (is_integer($transferAcl)) {
            $this->transferAclId = $transferAcl;
        } elseif ($transferAcl instanceof TransferAclInterface) {
            $this->transferAclId = $transferAcl->id;
        }
    }

    protected function setTemplate($template)
    {
        if (is_integer($template)) {
            $this->templateId = $template;
        } elseif ($template instanceof TemplateInterface) {
            $this->templateId = $template->id;
        }
    }

    protected function getTransferAcl(): ?TransferAclInterface
    {
        if (!$this->transferAclId) {
            return null;
        }
        return $this->client->transferacls->get($this->transferAclId);
    }

    protected function getVanity(): ?VanityNameServerInterface
    {
        if (!$this->vanityId) {
            return null;
        }
        return $this->client->vanity->get($this->vanityId);
    }

    protected function setName(string $name)
    {
        if ($this->id) {
            throw new ReadOnlyPropertyException('Unable to set name');
        }
        $this->props['name'] = $name;
    }

    public function transformForApi(): object
    {
        // Get the default API conversion
        $payload = parent::transformForApi();

        // We can't update these
        $payload->updated = $this->apiData ? $this->apiData->updated : null;
        $payload->created = $this->apiData ? $this->apiData->created : null;

        return $payload;
    }
}