<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Models\Common\CommonManagedDomain;

/**
 * @package DnsMadeEasy
 */
class ConciseManagedDomain extends CommonManagedDomain implements ConciseManagedDomainInterface
{
    protected array $props = [
        'name' => null,
        'activeThirdParties' => [],
        'gtdEnabled' => null,
        'templateId' => null,
        'folderId' => null,
        'updated' => null,
        'created' => null,
        'axfrServer' => [],
        'pendingActionid' => null,
        'delegateNameServers' => [],
    ];

    protected function getFull(): ManagedDomainInterface
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
}