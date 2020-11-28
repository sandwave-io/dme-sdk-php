<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\VanityNameServerManagerInterface;
use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;

/**
 * @package DnsMadeEasy
 */
class VanityNameServerManager extends AbstractManager implements VanityNameServerManagerInterface
{
    protected string $baseUri = '/dns/vanity';

    public function createObject(): VanityNameServerInterface
    {
        return parent::createObject();
    }

    public function get(int $id): VanityNameServerInterface
    {
        return parent::get($id);
    }
}