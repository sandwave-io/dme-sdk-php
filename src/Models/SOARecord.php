<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\SOARecordInterface;

/**
 * Represents a Custom SOA Record resource.
 *
 * @package DnsMadeEasy\Models
 *
 * @property string $email
 * @property int $expire
 * @property int $negativeCache
 * @property int $refresh
 * @property int $retry
 * @property int $serial
 * @property int $ttl
 * @property string $comp
 * @property string $name
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
