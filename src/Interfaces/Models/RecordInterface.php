<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Enums\GTDLocation;
use DnsMadeEasy\Enums\RecordType;

/**
 * Represents a Record.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property string $value
 * @property RecordType $type
 * @property string $name
 * @property-read int $source
 * @property-read int $sourceId
 * @property bool $dynamicDns
 * @property string $password
 * @property int $ttl
 * @property-read bool $monitor
 * @property-read bool $failover
 * @property-read bool $failed
 * @property GTDLocation $gtdLocation
 * @property string $description
 * @property string $keywords
 * @property string $title
 * @property string $redirectType
 * @property bool $hardlink
 * @property int $mxLevel
 * @property int $weight
 * @property int $priority
 * @property int $port
 */
interface RecordInterface extends AbstractModelInterface
{
}
