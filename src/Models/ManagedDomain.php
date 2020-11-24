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

    public function parseApiData(object $data): void
    {
        parent::parseApiData($data);
        $this->props['updated'] = new \DateTime('@' . floor($data->updated / 1000));
        $this->props['created'] = new \DateTime('@' . floor($data->created / 1000));
    }

    public function transformForApi(): object
    {
        $payload = parent::transformForApi();
        $payload->updated = $this->apiData ? $this->apiData->updated : null;
        $payload->created = $this->apiData ? $this->apiData->created : null;
        return $payload;
    }
}