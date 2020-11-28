<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\SecondaryIPSetManagerInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;

/**
 * @package DnsMadeEasy\Managers
 */
class SecondaryIPSetManager extends AbstractManager implements SecondaryIPSetManagerInterface
{
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