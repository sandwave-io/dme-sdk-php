<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseSecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;
use DnsMadeEasy\Models\Common\CommonSecondaryDomain;

/**
 * A concise representation of Secondary Domain resources from the API. This is returned from paginate() calls to the
 * manager. The full version of the resource can be requested if required.
 *
 * @package DnsMadeEasy\Models
 *
 * @property-read string $name
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property-read bool $gtdEnabled
 * @property-read int $nameServerGroupId
 * @property-read int $pendingActionId
 * @property-read SecondaryIPSetInterface $ipSet
 * @property-read int $ipSetId
 * @property-read FolderInterface $folder
 * @property-read int $folderId
 * @property-read SecondaryDomainInterface $full
 */
class ConciseSecondaryDomain extends CommonSecondaryDomain implements ConciseSecondaryDomainInterface
{
    protected array $props = [
        'name' => null,
        'gtdEnabled' => null,
        'ipSetId' => null,
        'folderId' => null,
        'updated' => null,
        'created' => null,
        'pendingActionid' => null,
        'nameServerGroupId' => [],
    ];

    /**
     * Override the save method, we can't save concise resources, so we don't do anything.
     *
     * @internal
     */
    public function save(): void
    {
    }

    /**
     * Override the refresh method. Refreshing it would fetch the full version of the resource.
     *
     * @internal
     */
    public function refresh(): void
    {
    }

    /**
     * Retrieves the full representation of the Secondary Domain.
     */
    protected function getFull(): SecondaryDomainInterface
    {
        return $this->manager->get($this->id);
    }

    /**
     * Return the Secondary IP set assigned to this domain.
     */
    protected function getIpSet(): ?SecondaryIPSetInterface
    {
        if ($this->ipSetId === null) {
            return null;
        }
        return $this->client->secondaryipsets->get($this->ipSetId);
    }
}
