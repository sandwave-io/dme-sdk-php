<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\Concise\ConciseSecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;
use DnsMadeEasy\Models\Common\CommonSecondaryDomain;

/**
 * @package DnsMadeEasy
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

    protected function getFull(): SecondaryDomainInterface
    {
        return $this->manager->get($this->id);
    }

    public function save(): void
    {
        return;
    }

    public function refresh(): void
    {
        return;
    }

    protected function getIpSet(): ?SecondaryIPSetInterface
    {
        if (!$this->ipSetId) {
            return null;
        }
        return $this->client->secondaryipsets->get($this->ipSetId);
    }
}