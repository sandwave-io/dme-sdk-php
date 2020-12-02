<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Managers\DomainRecordManagerInterface;
use DnsMadeEasy\Interfaces\Managers\MultipleRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Managers\Multiple\MultipleRecordManager;

/**
 * Represents a Domain Record.
 * @package DnsMadeEasy\Managers
 *
 * @property-read MultipleRecordManagerInterface $multiple;
 */
class DomainRecordManager extends RecordManager implements DomainRecordManagerInterface
{
    /**
     * The base URI for domain records.
     * @var string
     */
    protected string $baseUri = '/dns/managed/:domain/records';

    /**
     * Manager for multiple domain records.
     * @var MultipleRecordManager|null
     */
    protected ?MultipleRecordManagerInterface $multipleRecordManager = null;

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

    /**
     * Delete all records on the domain.
     * @throws HttpException
     */
    public function deleteAll(): void
    {
        $this->client->delete($this->baseUri);
    }

    public function __get($name)
    {
        if ($name == 'multiple') {
            if (!$this->multipleRecordManager) {
                $this->multipleRecordManager = new MultipleRecordManager($this->client, $this->domain);
            }
            return $this->multipleRecordManager;
        }
    }
}