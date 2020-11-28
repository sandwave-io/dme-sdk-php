<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Common\CommonFolderInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;

/**
 * Represents a concise version of the Folder resource
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property-read string $name
 * @property-read FolderInterface $full
 */
interface ConciseFolderInterface extends CommonFolderInterface
{
}