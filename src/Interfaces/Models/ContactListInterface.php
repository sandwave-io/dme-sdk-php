<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Contact List resource
 * @package DnsMadeEasy\Interfaces
 */
interface ContactListInterface extends AbstractModelInterface
{
    /**
     * Add an email to the contactlist.
     *
     * @param string $email
     * @return ContactListInterface
     */
    public function addEmail(string $email): ContactListInterface;

    /**
     * Remove an email from the contactlist.
     * @param string $email
     * @return ContactListInterface
     */
    public function removeEmail(string $email): ContactListInterface;
}