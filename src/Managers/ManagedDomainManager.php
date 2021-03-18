<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\ManagedDomainManagerInterface;
use DnsMadeEasy\Interfaces\Managers\MultipleDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Managers\Multiple\MultipleDomainManager;
use DnsMadeEasy\Models\Concise\ConciseManagedDomain;
use DnsMadeEasy\Models\ManagedDomain;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Manager for Managed Domain objects.
 *
 * @package DnsMadeEasy\Managers
 *
 * @property-read MultipleDomainManagerInterface $multiple;
 */
class ManagedDomainManager extends AbstractManager implements ManagedDomainManagerInterface, ListableManagerInterface
{
    use ListableManager;

    protected string $model = ManagedDomain::class;

    /**
     * Manager for multiple domains.
     *
     * @var MultipleDomainManagerInterface|null
     */
    protected ?MultipleDomainManagerInterface $multipleDomainManager = null;

    /**
     * Base URI for managed domain objects.
     *
     * @var string
     */
    protected string $baseUri = '/dns/managed';

    public function __get($name)
    {
        if ($name == 'multiple') {
            if (! $this->multipleDomainManager) {
                $this->multipleDomainManager = new MultipleDomainManager($this->client);
            }
            return $this->multipleDomainManager;
        }
    }

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
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function getConciseModelClass(): string
    {
        return ConciseManagedDomain::class;
    }
}
