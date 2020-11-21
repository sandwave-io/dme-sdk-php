<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

interface ContactListInterface extends AbstractModelInterface
{
    public function addEmail(string $email): ContactListInterface;
    public function removeEmail(string $email): ContactListInterface;
}