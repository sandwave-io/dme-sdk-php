<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Interfaces\Managers\DomainRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Models\TransferAcl;

/**
 * Represents a Managed Domain resource.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property string $name
 * @property-read array $activeThirdParties
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property bool $gtdEnabled
 * @property-read string[] $axfrServers
 * @property-read string[] $delegateNameServers
 * @property-read object[] $nameServers
 * @property SOARecordInterface $soa;
 * @property int $soaID
 * @property VanityNameServerInterface $vanity
 * @property int $vanityId
 * @property TransferAcl $transferAcl
 * @property int $transferAclId
 * @property FolderInterface $folder
 * @property int $folderId
 * @property TemplateInterface $template
 * @property int $templateId
 * @property-read DomainRecordManagerInterface $records
 *
 */
interface ManagedDomainInterface extends CommonManagedDomainInterface
{
}
