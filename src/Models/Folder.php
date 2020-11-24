<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\FolderInterface;

class Folder extends AbstractModel implements FolderInterface
{
    protected array $props = [
        'name' => null,
        'secondaries' => [],
        'folderPermissions' => [],
        'defaultFolder' => null,
    ];

    protected array $editable = [
        'name',
        'defaultFolder',
    ];
}