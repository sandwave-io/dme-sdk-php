<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\VanityNameServerManagerInterface;
use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Models\VanityNameServer;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Manager for Vanity NameServer resources.
 *
 * @package DnsMadeEasy\Managers
 */
class VanityNameServerManager extends AbstractManager implements
    VanityNameServerManagerInterface,
                                                                 ListableManagerInterface
{
    use ListableManager;

    protected string $model = VanityNameServer::class;

    /**
     * Base URI for Vanity NameServer resources.
     *
     * @var string
     */
    protected string $baseUri = '/dns/vanity';

    public function create(): VanityNameServerInterface
    {
        return $this->createObject();
    }

    public function get(int $id): VanityNameServerInterface
    {
        return $this->getObject($id);
    }
}
