<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents the usage of the service.
 *
 * @package DnsMadeEasy
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
interface UsageInterface
{
}