<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;

/**
 * Represents a concise version of a Managed Domain resource
 *
 * @package DnsMadeEasy
 *
 * @property-read ManagedDomainInterface $full
 */
interface ConciseManagedDomainInterface extends CommonManagedDomainInterface
{
}