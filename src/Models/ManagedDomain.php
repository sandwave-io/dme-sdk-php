<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseFolderInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
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

    protected array $editable = [
        'gtdEnabled',
        'folderId',
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

    public function getFolder(): ?FolderInterface
    {
        if (!$this->folderId) {
            return null;
        }
        return $this->client->folders->get($this->folderId);
    }

    public function getTransferAcl()
    {
        if (!$this->transferAclId) {
            return;
        }
    }

    public function setFolder($folder)
    {
        if (is_integer($folder)) {
            $this->folderId = $folder;
        } elseif ($folder instanceof FolderInterface || $folder instanceof ConciseFolderInterface) {
            $this->folderId = $folder->id;
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
        // Get the default API conversion
        $payload = parent::transformForApi();

        // We can't update these
        $payload->updated = $this->apiData ? $this->apiData->updated : null;
        $payload->created = $this->apiData ? $this->apiData->created : null;

        // These don't exist
        foreach ($payload as $key => $value) {
            if ($value === null || (is_array($value) && !$value)) {
                unset($payload->$key);
            }
        }

        return $payload;
    }
}