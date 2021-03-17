<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\RecordFailoverInterface;

/**
 * Manages record failover and monitoring resources.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface RecordFailoverManagerInterface
{
    /**
     * Returns the failover resource for the specified record ID. If the resource doesn't exist, a new one is created.
     *
     * @param int $recordId
     *
     * @throws HttpException
     * @throws \ReflectionException
     *
     * @return RecordFailoverInterface
     */
    public function get(int $recordId): RecordFailoverInterface;

    /**
     * Updates the API with changes made to the specified object. If the object is new, it will be created.
     *
     * @param RecordFailoverInterface $object
     *
     * @throws HttpException
     *
     * @internal
     */
    public function save(RecordFailoverInterface $recordFailover): void;

    /**
     * Uses the API to delete the specified object. If the object is new, then no action is taken on the API.
     *
     * @param RecordFailoverInterface $recordFailover
     *
     * @throws HttpException
     *
     * @internal
     */
    public function delete(RecordFailoverInterface $recordFailover): void;
}
