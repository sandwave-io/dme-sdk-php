<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Common\CommonSecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;

/**
 * Represents a concise version of a Secondary Domain resource
 *
 * @package DnsMadeEasy\Interfaces
 * @property-read string $name
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property-read bool $gtdEnabled
 * @property-read int $nameServerGroupId
 * @property-read int $pendingActionId
 *
 * @property-read SecondaryIPSetInterface $ipSet
 * @property-read int $ipSetId
 * @property-read FolderInterface $folder
 * @property-read int $folderId
 * @property-read SecondaryDomainInterface $full
 */
interface ConciseSecondaryDomainInterface extends CommonSecondaryDomainInterface
{
}