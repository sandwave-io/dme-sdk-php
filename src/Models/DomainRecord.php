<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

/**
 * @package DnsMadeEasy\Models
 *
 * @property ManagedDomainInterface $domain
 * @property int $domainId
 */
class DomainRecord extends Record implements DomainRecordInterface
{
    protected ?ManagedDomainInterface $domain = null;

    /**
     * @internal
     * @param ManagedDomainInterface $domain
     * @return $this
     * @throws ReadOnlyPropertyException
     */
    public function setDomain(ManagedDomainInterface $domain): self
    {
        if ($this->domain) {
            throw new ReadOnlyPropertyException('Domain can only be set once');
        }
        $this->domain = $domain;
        return $this;
    }

    protected function getDomain(): ?ManagedDomainInterface
    {
        return $this->domain;
    }

    protected function getDomainId(): ?int
    {
        if (!$this->domain) {
            return null;
        }
        return $this->domain->id;
    }
}