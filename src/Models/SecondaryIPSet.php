<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;

/**
 * @package DnsMadeEasy\Models
 *
 * @property string $name
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

    public function addIP(string $ip): self
    {
        if (!in_array($ip, $this->props['ips'])) {
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