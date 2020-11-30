<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\TransferAclManagerInterface;
use DnsMadeEasy\Interfaces\Models\TransferAclInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Manager for Transfer ACL resources.
 * @package DnsMadeEasy\Managers
 */
class TransferAclManager extends AbstractManager implements TransferAclManagerInterface, ListableManagerInterface
{
    use ListableManager;

    /**
     * Base URI for Transfer ACLs
     * @var string
     */
    protected string $baseUri = '/dns/transferAcl';

    public function create(): TransferAclInterface
    {
        return $this->createObject();
    }

    public function get(int $id): TransferAclInterface
    {
        return $this->getObject($id);
    }
}