<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Common;

use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;

/**
 * Represents the properties and methods common between full Folder and concise Folder objects. For use
 * when you only need these basic properties and methods.
 *
 * @package DnsMadeEasy
 *
 * @property-read string $name
 */
interface CommonFolderInterface extends AbstractModelInterface
{
}