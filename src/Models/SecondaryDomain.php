<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Models\Common\CommonFolderInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;
use DnsMadeEasy\Models\Common\CommonSecondaryDomain;

/**
 * Represents a Secondary Domain resource.
 *
 * @package DnsMadeEasy\Models
 *
 * @property string $name
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property-read bool $gtdEnabled
 * @property-read int $nameServerGroupId
 * @property-read int $pendingActionId
 * @property SecondaryIPSetInterface $ipSet
 * @property int $ipSetId
 * @property FolderInterface $folder
 * @property int $folderId
 * @property-read object[] $nameServers
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

    /**
     * @return object
     *
     * @internal
     */
    public function transformForApi(): object
    {
        $payload = (object) [];
        if (! $this->id) {
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

    /**
     * Sets the folder the domain has been assigned to.
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
     * Sets the secondary IP set for the domain.
     *
     * @param SecondaryIPSet $set
     */
    protected function setIpSet(SecondaryIPSet $set)
    {
        $this->props['ipSet'] = $set;
        $this->props['ipSetId'] = $set->id;
    }

    /**
     * Sets the secondary IP set ID for the domain.
     *
     * @param int $id
     */
    protected function setIpSetId(int $id)
    {
        $this->props['ipSetId'] = $id;
        $this->props['ipSet'] = null;
    }

    /**
     * Get the secondary IP set for the domain.
     *
     * @return mixed|null
     */
    protected function getIpSet()
    {
        if ($this->props['ipSet']) {
            return $this->props['ipSet'];
        } elseif ($this->props['ipSet']) {
            return $this->client->secondaryipsets->get($this->props['ipSet']);
        }
        return null;
    }

    /**
     * Set the name of the domain. This can only be set on new domain objects.
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

    protected function parseApiData(object $data): void
    {
        if ($data->ipSetId) {
            $data->ipSet = new SecondaryIPSet($this->client->secondaryipsets, $this->client, $data->ipSet);
        }
        parent::parseApiData($data);
    }
}
