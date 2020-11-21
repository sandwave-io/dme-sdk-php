<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Interfaces\Models\ContactListInterface;

interface ContactListManagerInterface extends AbstractManagerInterface
{
    public function createObject(): ContactListInterface;
    public function get(int $id): ContactListInterface;
}