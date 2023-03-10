<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Contact List resource.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property string   $name
 * @property object[] $emails
 * @property int[]    $groups
 */
interface ContactListInterface extends AbstractModelInterface
{
    /**
     * Add an email to the contactlist.
     */
    public function addEmail(string $email): ContactListInterface;

    /**
     * Remove an email from the contactlist.
     */
    public function removeEmail(string $email): ContactListInterface;
}
