<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;

/**
 * @package DnsMadeEasy\Models
 *
 * @property int $nameServerGroupId
 * @property string $nameServerGroup
 * @property bool $default
 * @property string[] $servers
 * @property-read bool $public
 * @property string $name
 * @property-read int $accountId
 */
class VanityNameServer extends AbstractModel implements VanityNameServerInterface
{
    protected array $props = [
        // Default the nameserver group to the DME values
        'nameServerGroupId' => 1,
        'nameServerGroup' => 'ns0,ns1,ns2,ns3,ns4.dnsmadeeasy.com',
        'default' => null,
        'servers' => [],
        'public' => null,
        'name' => null,
        'accountId' => null,
    ];

    protected array $editable = [
        'default',
        'servers',
        'name',
        'nameserverGroupId',
        'nameServerGroup',
    ];
}