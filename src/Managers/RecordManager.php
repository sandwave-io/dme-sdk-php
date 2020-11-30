<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Abstract class for Domain and Template record managers.
 * @package DnsMadeEasy\Managers
 */
abstract class RecordManager extends AbstractManager implements ListableManagerInterface
{
    use ListableManager;
}