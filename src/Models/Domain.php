<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\DomainInterface;

class Domain extends AbstractModel implements DomainInterface
{
    protected array $props = [
        'name' => null,
    ];
}