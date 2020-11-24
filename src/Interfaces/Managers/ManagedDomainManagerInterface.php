<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

interface ManagedDomainManagerInterface extends AbstractManagerInterface
{
    public function createObject(): ManagedDomainInterface;
    public function get(int $id): ManagedDomainInterface;
}