<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\ContactListInterface;

/**
 * Manages ContactList objects from the API.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface ContactListManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new ContactList.
     */
    public function create(): ContactListInterface;

    /**
     * Gets the ContactList with the specified ID.
     *
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): ContactListInterface;
}
