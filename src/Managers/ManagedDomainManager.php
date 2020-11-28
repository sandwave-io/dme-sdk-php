<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\ManagedDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Models\Concise\ConciseManagedDomain;

/**
 * @package DnsMadeEasy\Managers
 */
class ManagedDomainManager extends AbstractManager implements ManagedDomainManagerInterface
{
    protected string $baseUri = '/dns/managed';

    public function create(): ManagedDomainInterface
    {
        return $this->createObject();
    }

    public function get(int $id): ManagedDomainInterface
    {
        return $this->getObject($id);
    }

    protected function getConciseModelClass(): string
    {
        return ConciseManagedDomain::class;
    }
}