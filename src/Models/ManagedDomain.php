<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

class ManagedDomain extends AbstractModel implements ManagedDomainInterface
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

    public function getVanityNameserver()
    {
        if (!$this->vanityId) {
            return;
        }
    }

    public function getTemplate()
    {
        if (!$this->templateId) {
            return;
        }
    }

    public function getFolder()
    {
        if (!$this->folderId) {
            return;
        }
        return $this->client->folders->get($this->folderId);
    }

    public function getTransferAcl()
    {
        if (!$this->transferAclId) {
            return;
        }

    }
}