<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

/**
 * Manages Domain Record resources from the API
 * @package DnsMadeEasy\Interfaces
 */
interface DomainRecordManagerInterface extends AbstractManagerInterface
{
    /**
     * Sets the domain used for the manager.
     * @param ManagedDomainInterface $domain
     * @return $this
     */
    public function setDomain(ManagedDomainInterface $domain): self;

    /**
     * Creates a new Domain Record resource.
     * @return DomainRecordInterface
     */
    public function create(): DomainRecordInterface;

    /**
     * Returns the Domain Record resource with the specified ID.
     * @param int $id
     * @return DomainRecordInterface
     * @throws HttpException
     */
    public function get(int $id): DomainRecordInterface;
}