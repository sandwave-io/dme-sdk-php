<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\ContactListManagerInterface;
use DnsMadeEasy\Interfaces\Models\ContactListInterface;

/**
 * @package DnsMadeEasy\Managers
 */
class ContactListManager extends AbstractManager implements ContactListManagerInterface
{
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