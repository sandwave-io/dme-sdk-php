<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseFolderInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Models\AbstractModel;

class ConciseFolder extends AbstractModel implements ConciseFolderInterface
{
    protected array $props = [
        'name' => null,
    ];

    protected function getFull(): FolderInterface
    {
        return $this->manager->get($this->id);
    }

    public function save(): void
    {
        return;
    }

    protected function parseApiData(object $data): void
    {
        parent::parseApiData($data);
        $this->props['name'] = $data->label;
    }
}