<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseFolderInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Models\Common\CommonFolder;

/**
 * @package DnsMadeEasy\Models
 *
 * @property-read string $name
 * @property-read FolderInterface $full
 */
class ConciseFolder extends CommonFolder implements ConciseFolderInterface
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

    public function refresh(): void
    {
        return;
    }

    protected function parseApiData(object $data): void
    {
        parent::parseApiData($data);
        $this->props['name'] = $data->label;
    }
}