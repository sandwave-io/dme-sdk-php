<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Models\Common\CommonFolderInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Models\Common\CommonSecondaryDomain;
use DnsMadeEasy\Models\Concise\CommonManagedDomain;

/**
 * @package DnsMadeEasy
 */
class SecondaryDomain extends CommonSecondaryDomain implements SecondaryDomainInterface
{
    protected array $props = [
        'name' => null,
        'gtdEnabled' => null,
        'ipSetId' => null,
        'ipSet' => null,
        'nameServers' => [],
        'folderId' => null,
        'updated' => null,
        'created' => null,
        'pendingActionid' => null,
        'nameServerGroupId' => null,
    ];

    protected array $editable = [
        'ipSet',
        'ipSetId',
        'folderId',
    ];

    protected function setFolder($folder)
    {
        if (is_integer($folder)) {
            $this->folderId = $folder;
        } elseif ($folder instanceof CommonFolderInterface) {
            $this->folderId = $folder->id;
        }
    }

    protected function setIpSet(SecondaryIPSet $set)
    {
        $this->props['ipSet'] = $set;
        $this->props['ipSetId'] = $set->id;
    }

    protected function setIpSetId(int $id)
    {
        $this->props['ipSetId'] = $id;
        $this->props['ipSet'] = null;
    }

    protected function getIpSet()
    {
        if ($this->props['ipSet']) {
            return $this->props['ipSet'];
        } elseif ($this->props['ipSet']) {
            return $this->client->secondaryipsets->get($this->props['ipSet']);
        }
        return null;
    }

    protected function setName(string $name)
    {
        if ($this->id) {
            throw new ReadOnlyPropertyException('Unable to set name');
        }
        $this->props['name'] = $name;
    }

    protected function parseApiData(object $data): void
    {
        if ($data->ipSetId) {
            $data->ipSet = new SecondaryIPSet($this->client->secondaryipsets, $this->client, $data->ipSet);
        }
        parent::parseApiData($data);
    }

    public function transformForApi(): object
    {
        $payload = (object) [];
        if (!$this->id) {
            $payload->name = $this->name;
        }
        if ($this->ipSetId) {
            $payload->ipSetId = $this->ipSetId;
        }
        if ($this->folderId) {
            $payload->folderId = $this->folderId;
        }
        return $payload;
    }
}