<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;

/**
 * Manages Secondary Domain resources from the API.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface SecondaryDomainManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Secondary Domain resource.
     */
    public function create(): SecondaryDomainInterface;

    /**
     * Gets the Secondary Domain resource with the specified ID.
     *
     * @throws HttpException
     */
    public function get(int $id): SecondaryDomainInterface;
}
