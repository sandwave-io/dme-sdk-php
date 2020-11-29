<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Record
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property-read int $domainId
 * @property-read ManagedDomainInterface $domain
 */
interface DomainRecordInterface extends RecordInterface
{
    public function setDomain(ManagedDomainInterface $domain): self;
}