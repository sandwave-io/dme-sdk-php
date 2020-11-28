<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Models\Common\CommonManagedDomain;

/**
 * @package DnsMadeEasy\Models
 *
 * @property-read string $name
 * @property-read array $activeThirdParties
 * @property-read \DateTime $created
 * @property-read \DateTime $updated
 * @property-read bool $gtdEnabled
 * @property-read string[] $axfrServers
 * @property-read string[] $delegateNameservers
 *
 * @property-read FolderInterface $folder
 * @property-read int $folderId
 * @property-read TemplateInterface $template
 * @property-read int $templateId
 * @property-read ManagedDomainInterface $full
 */
class ConciseManagedDomain extends CommonManagedDomain implements ConciseManagedDomainInterface
{
    protected array $props = [
        'name' => null,
        'activeThirdParties' => [],
        'gtdEnabled' => null,
        'templateId' => null,
        'folderId' => null,
        'updated' => null,
        'created' => null,
        'axfrServer' => [],
        'pendingActionid' => null,
        'delegateNameServers' => [],
    ];

    protected function getFull(): ManagedDomainInterface
    {
        return $this->manager->get($this->id);
    }

    public function save(): void
    {
        return;
    }

    public function refresh(): void
    {
        return;
    }
}