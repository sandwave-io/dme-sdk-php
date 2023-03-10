<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;

/**
 * Represents a Secondary IP Set resource.
 *
 * @package DnsMadeEasy\Models
 *
 * @property string   $name
 * @property string[] $ips
 */
class SecondaryIPSet extends AbstractModel implements SecondaryIPSetInterface
{
    protected array $props = [
        'name' => null,
        'ips' => [],
    ];

    protected array $editable = [
        'name',
        'ips',
    ];

    public function addIP(string $ip): SecondaryIPSetInterface
    {
        if (! in_array($ip, $this->props['ips'], true)) {
            $this->props['ips'][] = $ip;
        }
        return $this;
    }

    public function removeIP(string $ip): SecondaryIPSetInterface
    {
        $index = array_search($ip, $this->props['ips'], true);
        if ($index !== false) {
            unset($this->props['ips'][$index]);
        }
        return $this;
    }
}
