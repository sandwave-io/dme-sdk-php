<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Record
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property string $value
 * @property string $type
 * @property-read int $source
 * @property-read int $sourceId
 * @property bool $dynamicDns
 * @property string $password
 * @property int $ttl
 * @property-read bool $monitor
 * @property-read bool $failover
 * @property-read bool $failed
 * @property string $gtdLocation
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