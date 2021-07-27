<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\ContactListInterface;
use DnsMadeEasy\Interfaces\Models\RecordFailoverInterface;
use DnsMadeEasy\Interfaces\Models\RecordInterface;

/**
 * Represents Record Failover and Monitoring Configuration.
 *
 * @package DnsMadeEasy\Models
 *
 * @property bool $monitor
 * @property int  $recordId
 * @property-read string $systemDescription
 * @property int    $maxEmails
 * @property int    $sensitivity
 * @property int    $protocolId
 * @property int    $port
 * @property bool   $failover
 * @property bool   $autoFailover
 * @property string $ip1
 * @property string $ip2
 * @property string $ip3
 * @property string $ip4
 * @property string $ip5
 * @property-read int $ip1Failed
 * @property-read int $ip2Failed
 * @property-read int $ip3Failed
 * @property-read int $ip4Failed
 * @property-read int $ip5Failed
 * @property-read int $source
 * @property-read int $sourceId
 * @property int                  $contactListId
 * @property ContactListInterface $contactList;
 * @property string               $httpFqdn
 * @property string               $httpFile
 * @property string               $httpQueryString
 * @property RecordInterface      $record
 */
class RecordFailover extends AbstractModel implements RecordFailoverInterface
{
    protected array $props = [
        'monitor' => null,
        'recordId' => null,
        'systemDescription' => null,
        'maxEmails' => null,
        'sensitivity' => null,
        'protocolId' => null,
        'port' => null,
        'failover' => null,
        'autoFailover' => null,
        'ip1' => null,
        'ip2' => null,
        'ip3' => null,
        'ip4' => null,
        'ip5' => null,
        'ip1Failed' => null,
        'ip2Failed' => null,
        'ip3Failed' => null,
        'ip4Failed' => null,
        'ip5Failed' => null,
        'source' => null,
        'sourceId' => null,
        'contactListId' => null,
        'httpFqdn' => null,
        'httpFile' => null,
        'httpQueryString' => null,
    ];

    protected array $editable = [
        'monitor',
        'recordId',
        'maxEmails',
        'sensitivity',
        'protocolId',
        'port',
        'failover',
        'autoFailover',
        'ip1',
        'ip2',
        'ip3',
        'ip4',
        'ip5',
        'contactListId',
        'httpFqdn',
        'httpFile',
        'httpQueryString',
    ];

    public function transformForApi(): object
    {
        $data = parent::transformForApi();
        unset($data->id);
        return $data;
    }

    public function save(): void
    {
        // This is different to most other models in that we care about recordId and not id.
        if ($this->recordId && ! $this->hasChanged()) {
            return;
        }
        $this->manager->save($this);
        $this->originalProps = $this->props;
        $this->changed = [];
    }
}
