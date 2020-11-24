<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\ManagedDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Models\ManagedDomain;

class ManagedDomainManager extends AbstractManager implements ManagedDomainManagerInterface
{
    protected string $baseUri = '/dns/managed';

    public function createObject(): ManagedDomainInterface
    {
        return new ManagedDomain($this);
    }

    public function get(int $id): ManagedDomainInterface
    {
        return parent::get($id);
    }
}