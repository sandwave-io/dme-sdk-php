<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\VanityNameServerManagerInterface;
use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;

/**
 * @package DnsMadeEasy\Managers
 */
class VanityNameServerManager extends AbstractManager implements VanityNameServerManagerInterface
{
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