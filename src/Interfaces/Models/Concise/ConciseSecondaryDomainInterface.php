<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Common\CommonSecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;

/**
 * Represents a concise version of a Secondary Domain resource
 *
 * @package DnsMadeEasy
 *
 * @property-read SecondaryDomainInterface $full
 */
interface ConciseSecondaryDomainInterface extends CommonSecondaryDomainInterface
{
}