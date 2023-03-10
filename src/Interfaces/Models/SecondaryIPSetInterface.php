<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Secondary IP Set resource.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property string   $name
 * @property string[] $ips
 */
interface SecondaryIPSetInterface extends AbstractModelInterface
{
    /**
     * Add an IP address to the secondary IP set.
     */
    public function addIP(string $ip): self;

    /**
     * Remove the IP address from the secondary IP set.
     */
    public function removeIP(string $ip): self;
}
