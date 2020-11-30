<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;

/**
 * Manages Vanity NameServer resources from the API.
 * @package DnsMadeEasy\Interfaces
 */
interface VanityNameServerManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Vanity NameServer resource.
     * @return VanityNameServerInterface
     */
    public function create(): VanityNameServerInterface;

    /**
     * Gets the Vanity NameServer resource with the specified ID.
     * @param int $id
     * @return VanityNameServerInterface
     * @throws HttpException
     */
    public function get(int $id): VanityNameServerInterface;
}