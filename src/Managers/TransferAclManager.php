<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\TransferAclManagerInterface;
use DnsMadeEasy\Interfaces\Models\TransferAclInterface;

/**
 * @package DnsMadeEasy
 */
class TransferAclManager extends AbstractManager implements TransferAclManagerInterface
{
    protected string $baseUri = '/dns/transferAcl';

    public function createObject(): TransferAclInterface
    {
        return parent::createObject();
    }

    public function get(int $id): TransferAclInterface
    {
        return parent::get($id);
    }
}