<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Common;

use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\UsageInterface;

/**
 * Represents the properties and methods common between full SecondaryDomain and concise SecondaryDomain objects. For
 * use when you only need these basic properties and methods.
 *
 * @package DnsMadeEasy
 *
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
 */
interface CommonSecondaryDomainInterface extends AbstractModelInterface
{
}