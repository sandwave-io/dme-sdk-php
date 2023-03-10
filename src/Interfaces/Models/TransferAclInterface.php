<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Transfer ACL (AXFR).
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property string   $name
 * @property string[] $ips
 */
interface TransferAclInterface extends AbstractModelInterface
{
    /**
     * Add an IP address to the ACL's IPs.
     */
    public function addIP(string $ip): self;

    /**
     * Remove the IP address from the ACL's IPs.
     */
    public function removeIP(string $ip): self;
}
