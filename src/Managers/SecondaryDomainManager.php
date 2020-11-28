<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\SecondaryDomainManagerInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Models\Concise\ConciseSecondaryDomain;

/**
 * @package DnsMadeEasy\Managers
 */
class SecondaryDomainManager extends AbstractManager implements SecondaryDomainManagerInterface
{
    protected string $baseUri = '/dns/secondary';

    public function create(): SecondaryDomainInterface
    {
        return $this->createObject();
    }

    public function get(int $id): SecondaryDomainInterface
    {
        return $this->getObject($id);
    }

    protected function getConciseModelClass(): string
    {
        return ConciseSecondaryDomain::class;
    }
}