<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\SOARecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\SOARecordInterface;

/**
 * @package DnsMadeEasy
 */
class SOARecordManager extends AbstractManager implements SOARecordManagerInterface
{
    protected string $baseUri = '/dns/soa';

    public function createObject(): SOARecordInterface
    {
        return parent::createObject();
    }

    public function get(int $id): SOARecordInterface
    {
        return parent::get($id);
    }
}