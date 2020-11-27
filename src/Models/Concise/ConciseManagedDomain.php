<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Models\AbstractModel;

class ConciseManagedDomain extends AbstractModel implements ConciseManagedDomainInterface
{
    protected array $props = [
        'name' => null,
        'activeThirdParties' => [],
        'gtdEnabled' => null,
        'templateId' => null,
        'folderId' => null,
        'updated' => null,
        'created' => null,
        'axfrServer' => [],
        'delegateNameServers' => [],
    ];

    protected function getFull(): ManagedDomainInterface
    {
        return $this->manager->get($this->id);
    }

    public function save(): void
    {
        return;
    }

    public function parseApiData(object $data): void
    {
        parent::parseApiData($data);
        $this->props['updated'] = new \DateTime('@' . floor($data->updated / 1000));
        $this->props['created'] = new \DateTime('@' . floor($data->created / 1000));
    }
}