<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\ContactListManagerInterface;
use DnsMadeEasy\Interfaces\Models\ContactListInterface;

/**
 * @package DnsMadeEasy
 */
class ContactListManager extends AbstractManager implements ContactListManagerInterface
{
    protected string $baseUri = '/contactList';

    public function createObject(): ContactListInterface
    {
        return parent::createObject();
    }

    public function get(int $id): ContactListInterface
    {
        return parent::get($id);
    }
}