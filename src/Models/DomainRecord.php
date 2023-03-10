<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

/**
 * Represents a Domain Record.
 *
 * @package DnsMadeEasy\Models
 *
 * @property ManagedDomainInterface $domain
 * @property int                    $domainId
 */
class DomainRecord extends Record implements DomainRecordInterface
{
    protected ?ManagedDomainInterface $domain = null;

    /**
     * Sets the domain for the record. This can only be set once.
     *
     * @throws ReadOnlyPropertyException
     *
     * @internal
     */
    public function setDomain(ManagedDomainInterface $domain): self
    {
        if ($this->domain !== null) {
            throw new ReadOnlyPropertyException('Domain can only be set once');
        }
        $this->domain = $domain;
        return $this;
    }

    /**
     * Get the domain associated with this record.
     */
    public function getDomain(): ?ManagedDomainInterface
    {
        return $this->domain;
    }

    /**
     * Get the ID of the domain associated with the record.
     */
    public function getDomainId(): ?int
    {
        if ($this->domain === null) {
            return null;
        }
        return $this->domain->id;
    }
}
