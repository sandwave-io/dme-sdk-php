<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Interfaces\Models\Common\CommonSecondaryDomainInterface;

/**
 * Represents a Managed Domain resource.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property string $name
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property-read bool $gtdEnabled
 * @property-read int $nameServerGroupId
 * @property-read int $pendingActionId
 * @property SecondaryIPSetInterface $ipSet
 * @property int $ipSetId
 * @property FolderInterface $folder
 * @property int $folderId
 * @property-read object[] $nameServers
 */
interface SecondaryDomainInterface extends CommonSecondaryDomainInterface
{
}
