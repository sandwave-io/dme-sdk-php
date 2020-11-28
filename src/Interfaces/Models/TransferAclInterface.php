<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Transfer ACL (AXFR)
 *
 * @package DnsMadeEasy\Interfaces
 */
interface TransferAclInterface extends AbstractModelInterface
{
    /**
     * Add an IP address to the ACL's IPs.
     * @param string $ip
     * @return $this
     */
    public function addIP(string $ip): self;

    /**
     * Remove the IP address from the ACL's IPs.
     * @param string $ip
     * @return $this
     */
    public function removeIP(string $ip): self;
}