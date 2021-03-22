<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Enums\GTDLocation;
use DnsMadeEasy\Enums\RecordType;
use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Exceptions\DnsMadeEasyException;
use DnsMadeEasy\Interfaces\Models\RecordFailoverInterface;
use DnsMadeEasy\Interfaces\Models\RecordInterface;

/**
 * Abstract model representing records for domains and templates.
 *
 * @package DnsMadeEasy\Models
 *
 * @property string $value
 * @property string $type
 * @property string $name
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
abstract class Record extends AbstractModel implements RecordInterface
{
    protected array $props = [
        'value' => null,
        'type' => null,
        'name' => null,
        'source' => null,
        'sourceId' => null,
        'dynamicDns' => null,
        'password' => null,
        'ttl' => 3600,
        'monitor' => null,
        'failover' => null,
        'failed' => null,
        'gtdLocation' => null,
        'description' => null,
        'keywords' => null,
        'title' => null,
        'redirectType' => null,
        'hardlink' => null,
        'mxLevel' => null,
        'weight' => null,
        'priority' => null,
        'port' => null,

    ];

    protected array $editable = [
        'name',
        'value',
        'type',
        'dynamicDns',
        'password',
        'ttl',
        'gtdLocation',
        'description',
        'keywords',
        'title',
        'redirectType',
        'hardlink',
        'mxLevel',
        'weight',
        'priority',
        'port',
        'monitor',
        'failover',
    ];

    /**
     * @return mixed|object
     *
     * @internal
     */
    public function jsonSerialize()
    {
        $obj = parent::jsonSerialize();
        if ($obj->type) {
            $obj->type = $obj->type->value;
        }
        if ($obj->gtdLocation) {
            $obj->gtdLocation = $obj->gtdLocation->value;
        }
        return $obj;
    }

    /**
     * Get the record's failover and monitoring configuration.
     *
     * @throws DnsMadeEasyException
     *
     * @return RecordFailoverInterface
     */
    public function getRecordFailover(): RecordFailoverInterface
    {
        if (! $this->id) {
            throw new DnsMadeEasyException('Unable to fetch failover record for a record that has not been saved');
        }
        return $this->client->failover->get($this->id);
    }

    protected function parseApiData(object $data): void
    {
        if (property_exists($data, 'type') && $data->type) {
            $data->type = new RecordType($data->type);
        }
        if (property_exists($data, 'gtdLocation') && $data->gtdLocation) {
            $data->gtdLocation = new GTDLocation($data->gtdLocation);
        }
        parent::parseApiData($data);
    }

    /**
     * Sets the type of record. This can only be done on new records.
     *
     * @param RecordType $type
     *
     * @throws ReadOnlyPropertyException
     */
    protected function setType(RecordType $type)
    {
        if ($this->id && $this->props['type']) {
            throw new ReadOnlyPropertyException('Type can only be set before a record has been saved');
        }
        $this->props['type'] = $type;
    }
}
