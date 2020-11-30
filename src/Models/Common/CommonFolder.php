<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Common;

use DnsMadeEasy\Interfaces\Models\Common\CommonFolderInterface;
use DnsMadeEasy\Models\AbstractModel;

/**
 * Abstract model representing common properties and functionality between folder implementations.
 * @package DnsMadeEasy\Models
 */
abstract class CommonFolder extends AbstractModel implements CommonFolderInterface
{
}