<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\DomainRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

/**
 * @package DnsMadeEasy\Managers
 */
class DomainRecordManager extends AbstractManager implements DomainRecordManagerInterface
{
    protected string $baseUri = '/dns/managed/:domain/records';
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
     * @internal
     * @param ManagedDomainInterface $domain
     * @return $this|DomainRecordManagerInterface
     */
    public function setDomain(ManagedDomainInterface $domain): DomainRecordManagerInterface
    {
        $this->domain = $domain;
        $this->baseUri = str_replace(':domain', $domain->id, $this->baseUri);
        return $this;
    }

    /**
     * @internal
     * @return ManagedDomainInterface|null
     */
    public function getDomain(): ?ManagedDomainInterface
    {
        return $this->domain;
    }

    protected function createObject(?string $className = null): AbstractModelInterface
    {
        $record = parent::createObject($className);
        $record->setDomain($this->domain);
        return $record;
    }
}