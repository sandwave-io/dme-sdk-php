<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\UsageInterface;

/**
 * Gets usage from the API.
 * @package DnsMadeEasy\Interfaces
 */
interface UsageManagerInterface
{
    /**
     * Creates the Usage Manager.
     * @param ClientInterface $client
     * @internal
     */
    public function __construct(ClientInterface $client);

    /**
     * Returns all usage from the API.
     * @return UsageInterface[]
     */
    public function all(): array;

    /**
     * Fetches usage for the specified year and month.
     * @param int $year
     * @param int $month
     * @return UsageInterface[]
     */
    public function forMonth(int $year, int $month): array;

    /**
     * Fetches usage for the specified domain ID, year and month
     * @param int $domainId
     * @param int $year
     * @param int $month
     * @return UsageInterface[]
     */
    public function forDomainId(int $domainId, int $year, int $month): array;

    /**
     * Fetches usage for the specified domain, year and month
     * @param CommonManagedDomainInterface $domain
     * @param int $year
     * @param int $month
     * @return UsageInterface[]
     * @throws HttpException
     */
    public function forDomain(CommonManagedDomainInterface $domain, int $year, int $month);
}