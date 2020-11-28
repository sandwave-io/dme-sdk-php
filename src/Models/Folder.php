<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Models\Common\CommonFolder;

/**
 * @package DnsMadeEasy
 */
class Folder extends CommonFolder implements FolderInterface
{
    protected array $props = [
        'name' => null,
        'domains' => [],
        'secondaries' => [],
        'folderPermissions' => [],
        'defaultFolder' => null,
    ];

    protected array $editable = [
        'name',
        'defaultFolder',
    ];
}