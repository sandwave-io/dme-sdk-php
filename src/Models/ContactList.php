<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\ContactListInterface;

class ContactList extends AbstractModel implements ContactListInterface
{
    protected array $props = [
        'name' => null,
        'emails' => [],
        'groups' => [],
    ];
    public function populateFromApi(object $data): void
    {
        parent::populateFromApi($data);

        $this->props['name'] = $data->name;
        $this->props['emails'] = $data->emails;
        $this->props['groups'] = $data->groups;

        $this->originalProps = $this->props;
    }

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