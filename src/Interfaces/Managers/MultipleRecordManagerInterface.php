<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;


use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;

/**
 * Manages creation, deletion and updating of multiple domain records.
 * @package DnsMadeEasy\Interfaces
 */
interface MultipleRecordManagerInterface
{

    /**
     * Creates a new manager for the supplied domain.
     * @param ClientInterface $client
     * @param CommonManagedDomainInterface $domain
     */
    public function __construct(ClientInterface $client, CommonManagedDomainInterface $domain);

    /**
     * Creates the supplied records in a single API call. This will return a new array containing new objects for the
     * newly created records.
     * @param DomainRecordInterface[] $records
     * @return DomainRecordInterface[]
     * @throws HttpException
     */
    public function create(array $records): array;

    /**
     * Updates the supplied records in a single API call.
     * @param DomainRecordInterface[] $records
     * @throws HttpException
     */
    public function update(array $records): void;

    /**
     * Deletes the records matching the IDs specified.
     * @param int[] $ids
     * @throws HttpException
     */
    public function delete(array $ids): void;
}