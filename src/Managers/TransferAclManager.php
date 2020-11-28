<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\TransferAclManagerInterface;
use DnsMadeEasy\Interfaces\Models\TransferAclInterface;

/**
 * @package DnsMadeEasy\Managers
 */
class TransferAclManager extends AbstractManager implements TransferAclManagerInterface
{
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