<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\SecondaryDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Models\Concise\ConciseSecondaryDomain;

/**
 * @package DnsMadeEasy
 */
class SecondaryDomainManager extends AbstractManager implements SecondaryDomainManagerInterface
{
    protected string $baseUri = '/dns/secondary';

    public function createObject(): SecondaryDomainInterface
    {
        return parent::createObject();
    }

    public function get(int $id): SecondaryDomainInterface
    {
        return parent::get($id);
    }

    public function getConciseModelClass(): string
    {
        return ConciseSecondaryDomain::class;
    }
}