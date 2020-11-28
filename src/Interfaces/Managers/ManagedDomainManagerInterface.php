<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

/**
 * Manages Managed Domain resources from the API.
 * @package DnsMadeEasy\Interfaces
 */
interface ManagedDomainManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Managed Domain.
     * @return ManagedDomainInterface
     */
    public function create(): ManagedDomainInterface;

    /**
     * Gets the ManagedDomain with the specified ID.
     * @param int $id
     * @return ManagedDomainInterface
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): ManagedDomainInterface;
}