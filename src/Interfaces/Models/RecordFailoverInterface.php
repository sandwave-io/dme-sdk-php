<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents record failover configuration.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property bool $monitor
 * @property int $recordId
 * @property-read string $systemDescription
 * @property int $maxEmails
 * @property int $sensitivity
 * @property int $protocolId
 * @property int $port
 * @property bool $failover
 * @property bool $autoFailover
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
 * @property int $contactListId
 * @property ContactListInterface $contactList;
 * @property string $httpFqdn
 * @property string $httpFile
 * @property string $httpQueryString
 * @property RecordInterface $record
 */
interface RecordFailoverInterface extends RecordInterface
{
}