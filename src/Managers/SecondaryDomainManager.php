<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\SecondaryDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Models\Concise\ConciseSecondaryDomain;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Manager for Secondary Domain resources.
 * @package DnsMadeEasy\Managers
 */
class SecondaryDomainManager extends AbstractManager implements SecondaryDomainManagerInterface,
                                                                ListableManagerInterface
{
    use ListableManager;

    /**
     * Base URI for secondary domain resources.
     * @var string
     */
    protected string $baseUri = '/dns/secondary';

    public function create(): SecondaryDomainInterface
    {
        return $this->createObject();
    }

    public function get(int $id): SecondaryDomainInterface
    {
        return $this->getObject($id);
    }

    /**
     * Return the name of the model class for the concise version secondary domain resources.
     * @return string
     */
    protected function getConciseModelClass(): string
    {
        return ConciseSecondaryDomain::class;
    }
}