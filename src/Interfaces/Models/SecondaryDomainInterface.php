<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Interfaces\Models\Common\CommonSecondaryDomainInterface;

/**
 * Represents a Managed Domain resource
 *
 * @package DnsMadeEasy
 *
 * @property string $name
 * @property-read bool $gtdEnabled
 *
 * @property SecondaryIPSetInterface $ipSet
 * @property int $ipSetId
 * @property FolderInterface $folder
 * @property int $folderId
 * @property-read object[] $nameServers
 */
interface SecondaryDomainInterface extends CommonSecondaryDomainInterface
{
}