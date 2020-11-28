<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Managers\UsageManagerInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\UsageInterface;

/**
 * @package DnsMadeEasy\Models
 *
 * @property-read int $primaryCount
 * @property-read int $primaryTotal
 * @property-read int $secondaryCount
 * @property-read int $secondaryTotal
 * @property-read int[] $listOfMonths
 * @property-read int[] $listOfYears
 * @property-read int $month
 * @property-read int $day
 * @property-read int $accountId
 * @property-read int $total
 * @property-read int $domainId
 * @property-read ManagedDomainInterface $domain
 */
class Usage extends AbstractModel implements UsageInterface
{
    protected array $props = [
        'primaryCount' => null,
        'primaryTotal' => null,
        'secondaryCount' => null,
        'secondaryTotal' => null,
        'listOfMonths' => [],
        'listOfYears' => [],
        'month' => null,
        'day' => null,
        'accountId' => null,
        'total' => null,
        'domainId' => null,
    ];

    protected function getDomain(): ?ManagedDomainInterface
    {
        if (!$this->domainId) {
            return null;
        }
        return $this->client->domain->get($this->domainId);
    }

    public function __toString()
    {
        return 'Usage';
    }

    public function save(): void
    {
        return;
    }

    public function delete(): void
    {
        return;
    }

    public function refresh(): void
    {
        return;
    }
}