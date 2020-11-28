<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\ContactListInterface;

/**
 * Manages ContactList objects from the API.
 * @package DnsMadeEasy
 */
interface ContactListManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new ContactList.
     * @return ContactListInterface
     */
    public function createObject(): ContactListInterface;

    /**
     * Gets the ContactList with the specified ID.
     * @param int $id
     * @return ContactListInterface
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): ContactListInterface;
}