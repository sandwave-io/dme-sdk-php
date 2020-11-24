<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\ManagedDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

class ManagedDomainManager extends AbstractManager implements ManagedDomainManagerInterface
{
    protected string $baseUri = '/dns/managed';

    public function createObject(): ManagedDomainInterface
    {
        return parent::createObject();
    }

    public function get(int $id): ManagedDomainInterface
    {
        return parent::get($id);
    }
}