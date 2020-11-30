<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Managers\ManagedDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Models\Concise\ConciseManagedDomain;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Manager for Managed Domain objects.
 * @package DnsMadeEasy\Managers
 */
class ManagedDomainManager extends AbstractManager implements ManagedDomainManagerInterface, ListableManagerInterface
{
    use ListableManager;

    /**
     * Base URI for managed domain objects
     * @var string
     */
    protected string $baseUri = '/dns/managed';

    public function create(): ManagedDomainInterface
    {
        return $this->createObject();
    }

    public function get(int $id): ManagedDomainInterface
    {
        return $this->getObject($id);
    }
    /**
     * Return the name of the model class for the concise version of a managed domains.
     * @return string
     * @throws \ReflectionException
     */
    protected function getConciseModelClass(): string
    {
        return ConciseManagedDomain::class;
    }
}