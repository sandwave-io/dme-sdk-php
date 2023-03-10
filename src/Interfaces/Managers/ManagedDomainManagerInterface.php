<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Managers\Multiple\MultipleDomainManager;

/**
 * Manages Managed Domain resources from the API.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property-read MultipleDomainManager $multiple;
 */
interface ManagedDomainManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Managed Domain.
     */
    public function create(): ManagedDomainInterface;

    /**
     * Gets the ManagedDomain with the specified ID.
     *
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): ManagedDomainInterface;
}
