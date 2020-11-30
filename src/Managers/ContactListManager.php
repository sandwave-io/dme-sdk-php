<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\ContactListManagerInterface;
use DnsMadeEasy\Interfaces\Models\ContactListInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Represents a Contact List API resource.
 * @package DnsMadeEasy\Managers
 */
class ContactListManager extends AbstractManager implements ContactListManagerInterface, ListableManagerInterface
{
    use ListableManager;

    /**
     * The base URI for contact lists.
     * @var string
     */
    protected string $baseUri = '/contactList';

    public function create(): ContactListInterface
    {
        return $this->createObject();
    }

    public function get(int $id): ContactListInterface
    {
        return $this->getObject($id);
    }
}