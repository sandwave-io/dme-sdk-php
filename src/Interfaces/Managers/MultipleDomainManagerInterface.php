<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\ClientInterface;

/**
 * Manages creation, updation and deletion of multiple domains.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface MultipleDomainManagerInterface
{
    /**
     * Creates a new Multiple Domain Manager.
     */
    public function __construct(ClientInterface $client);

    /**
     * Creates new domains with the specified names and the properties.
     *
     * @param string[] $domainNames
     *
     * @throws HttpException
     *
     * @return mixed[]
     */
    public function create(array $domainNames, ?object $properties = null): array;

    /**
     * Updates the domains with the IDs specified, with the properties in the properties object.
     *
     * @param int[] $ids
     *
     * @throws HttpException
     */
    public function update(array $ids, ?object $properties = null): void;

    /**
     * Deletes the domains with the specified IDs.
     *
     * @param int[] $ids
     *
     * @throws HttpException
     */
    public function delete(array $ids): void;
}
