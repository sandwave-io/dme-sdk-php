<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\DomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\DomainInterface;
use DnsMadeEasy\Models\Domain;

class DomainManager extends AbstractManager implements DomainManagerInterface
{
    protected string $baseUri = '/dns/managed';

    public function createObject(): DomainInterface
    {
        return new Domain($this);
    }

    public function get(int $id): DomainInterface
    {
        return parent::get($id);
    }
}