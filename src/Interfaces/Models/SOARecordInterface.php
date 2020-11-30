<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents an SOA Record
 *
 * @package DnsMadeEasy\Interfaces
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
interface SOARecordInterface extends AbstractModelInterface
{
}