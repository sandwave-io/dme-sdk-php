<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\TransferAclInterface;

/**
 * Manages Transfer ACL resources from the API.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface TransferAclManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Transfer ACL resource.
     */
    public function create(): TransferAclInterface;

    /**
     * Returns the TransferAcl resource with the specified ID.
     *
     * @throws HttpException
     */
    public function get(int $id): TransferAclInterface;
}
