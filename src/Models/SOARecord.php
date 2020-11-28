<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\SOARecordInterface;

/**
 * @package DnsMadeEasy
 */
class SOARecord extends AbstractModel implements SOARecordInterface
{
    protected array $props = [
        'name' => null,
        'comp' => null,
        'email' => null,
        'ttl' => 86400,
        'serial' => null,
        'refresh' => 14400,
        'retry' => 1800,
        'expire' => 86400,
        'negativeCache' => 1800,
    ];

    protected array $editable = [
        'name',
        'comp',
        'email',
        'ttl',
        'serial',
        'refresh',
        'retry',
        'expire',
        'negativeCache',
    ];
}