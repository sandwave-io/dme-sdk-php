<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\SOARecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\SOARecordInterface;

/**
 * @package DnsMadeEasy\Managers
 */
class SOARecordManager extends AbstractManager implements SOARecordManagerInterface
{
    protected string $baseUri = '/dns/soa';

    public function create(): SOARecordInterface
    {
        return $this->createObject();
    }

    public function get(int $id): SOARecordInterface
    {
        return $this->getObject($id);
    }
}