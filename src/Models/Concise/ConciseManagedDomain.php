<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Concise;

use DnsMadeEasy\Interfaces\Models\Concise\ConciseManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Models\Common\CommonManagedDomain;

/**
 * A concise representation of Managed Domain resources from the API. This is returned from paginate() calls to the
 * manager. The full version of the resource can be requested if required.
 *
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

    /**
     * Retrieves the full representation of the ManagedDomain.
     * @return ManagedDomainInterface
     */
    protected function getFull(): ManagedDomainInterface
    {
        return $this->manager->get($this->id);
    }

    /**
     * Override the save method, we can't save concise resources, so we don't do anything.
     * @internal
     */
    public function save(): void
    {
        return;
    }

    /**
     * Override the refresh method. Refreshing it would fetch the full version of the resource.
     */
    public function refresh(): void
    {
        return;
    }
}