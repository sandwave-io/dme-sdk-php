<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;

/**
 * Represents a concise version of a Managed Domain resource.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property-read string $name
 * @property-read array $activeThirdParties
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property-read bool $gtdEnabled
 * @property-read string[] $axfrServers
 * @property-read string[] $delegateNameservers
 * @property-read FolderInterface $folder
 * @property-read int $folderId
 * @property-read TemplateInterface $template
 * @property-read int $templateId
 * @property-read ManagedDomainInterface $full
 */
interface ConciseManagedDomainInterface extends CommonManagedDomainInterface
{
}
