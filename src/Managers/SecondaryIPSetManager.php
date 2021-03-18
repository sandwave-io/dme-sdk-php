<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\SecondaryIPSetManagerInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Manager for Secondary Domain IP sets.
 *
 * @package DnsMadeEasy\Managers
 */
class SecondaryIPSetManager extends AbstractManager implements SecondaryIPSetManagerInterface, ListableManagerInterface
{
    use ListableManager;

    /**
     * Base URI for secondary domain IP sets.
     *
     * @var string
     */
    protected string $baseUri = '/dns/secondary/ipSet';

    public function create(): SecondaryIPSetInterface
    {
        return $this->createObject();
    }

    public function get(int $id): SecondaryIPSetInterface
    {
        return $this->getObject($id);
    }
}
