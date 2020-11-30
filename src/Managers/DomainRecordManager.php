<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\DomainRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

/**
 * Represents a Domain Record.
 * @package DnsMadeEasy\Managers
 */
class DomainRecordManager extends RecordManager implements DomainRecordManagerInterface
{
    /**
     * The base URI for domain records.
     * @var string
     */
    protected string $baseUri = '/dns/managed/:domain/records';

    /**
     * The domain for this manager.
     * @var ManagedDomainInterface|null
     */
    protected ?ManagedDomainInterface $domain = null;

    public function create(): DomainRecordInterface
    {
        return $this->createObject();
    }

    public function get(int $id): DomainRecordInterface
    {
        return $this->getObject($id);
    }

    /**
     * Sets the domain used for the manager.
     * @param ManagedDomainInterface $domain
     * @return $this
     * @internal
     */
    public function setDomain(ManagedDomainInterface $domain): DomainRecordManagerInterface
    {
        $this->domain = $domain;
        $this->baseUri = str_replace(':domain', $domain->id, $this->baseUri);
        return $this;
    }

    /**
     * Fetches the domain for the manager.
     * @return ManagedDomainInterface|null
     * @internal
     */
    public function getDomain(): ?ManagedDomainInterface
    {
        return $this->domain;
    }

    /**
     * Creates a new instance of a Domain Record with the Domain property set.
     * @param string|null $className
     * @return AbstractModelInterface
     */
    protected function createObject(?string $className = null): AbstractModelInterface
    {
        $record = parent::createObject($className);
        $record->setDomain($this->domain);
        return $record;
    }
}