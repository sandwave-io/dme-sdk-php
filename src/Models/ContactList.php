<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\ContactListInterface;

/**
 * Represents a Contact List resource.
 *
 * @package DnsMadeEasy\Models
 *
 * @property string $name
 * @property string[] $emails
 * @property int[] $groups
 */
class ContactList extends AbstractModel implements ContactListInterface
{
    protected array $props = [
        'name' => null,
        'emails' => [],
        'groups' => [],
    ];

    protected array $editable = [
        'name',
        'emails',
        'groups',
    ];

    public function addEmail(string $email): self
    {
        $emails = $this->emails;
        foreach ($emails as $obj) {
            if ($obj->email === $email) {
                return $this;
            }
        }
        $emails[] = (object) [
            'email' => $email,
            'confirmed' => false,
        ];
        $this->emails = $emails;
        return $this;
    }

    public function removeEmail(string $email): self
    {
        $emails = $this->emails;
        foreach ($emails as $index => $obj) {
            if ($obj->email === $email) {
                unset($emails[$index]);
                $this->emails = $emails;
                return $this;
            }
        }
        return $this;
    }
}
