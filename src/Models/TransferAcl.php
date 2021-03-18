<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\TransferAclInterface;

/**
 * Represents a Transfer ACL (AXFR) resource.
 *
 * @package DnsMadeEasy\Models
 *
 * @property string $name
 * @property string[] $ips
 */
class TransferAcl extends AbstractModel implements TransferAclInterface
{
    protected array $props = [
        'ips' => [],
        'name' => null,
    ];

    protected array $editable = [
        'ips',
        'name',
    ];

    public function addIP(string $ip): self
    {
        if (! in_array($ip, $this->props['ips'])) {
            $this->props['ips'][] = $ip;
        }
        return $this;
    }

    public function removeIP(string $ip): self
    {
        $index = array_search($ip, $this->props['ips']);
        if ($index !== false) {
            unset($this->props['ips'][$index]);
        }
        return $this;
    }
}
