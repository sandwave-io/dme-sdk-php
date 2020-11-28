<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\TransferAclInterface;

/**
 * Manages Transfer ACL resources from the API.
 * @package DnsMadeEasy\Interfaces\Managers
 */
interface TransferAclManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Transfer ACL resource.
     * @return TransferAclInterface
     */
    public function createObject(): TransferAclInterface;

    /**
     * Returns the TransferAcl resource with the specified ID.
     * @param int $id
     * @return TransferAclInterface
     * @throws HttpException
     */
    public function get(int $id): TransferAclInterface;
}