<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\VanityNameServerInterface;

/**
 * @package DnsMadeEasy
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