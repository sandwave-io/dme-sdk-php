<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Interfaces\Models\Common\CommonFolderInterface;

/**
 * Represents a Folder resource
 *
 * @package DnsMadeEasy\Interfaces\Models
 *
 * @property string $name
 * @property-read int[] $domains
 * @property-read int[] $secondaries
 * @property-read object $folderPermissions
 * @property bool $defaultFolder
 */
interface FolderInterface extends CommonFolderInterface
{
}