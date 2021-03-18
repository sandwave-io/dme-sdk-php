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
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client);

    /**
     * Creates new domains with the specified names and the properties.
     *
     * @param array       $domainNames
     * @param object|null $properties
     *
     * @throws HttpException
     *
     * @return array
     */
    public function create(array $domainNames, ?object $properties = null): array;

    /**
     * Updates the domains with the IDs specified, with the properties in the properties object.
     *
     * @param array       $ids
     * @param object|null $properties
     *
     * @throws HttpException
     */
    public function update(array $ids, ?object $properties = null): void;

    /**
     * Deletes the domains with the specified IDs.
     *
     * @param array $ids
     *
     * @throws HttpException
     */
    public function delete(array $ids): void;
}
