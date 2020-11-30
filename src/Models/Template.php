<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Managers\TemplateRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Managers\TemplateRecordManager;

/**
 * Represents a Template resource.
 * @package DnsMadeEasy\Models
 *
 * @property string $name
 * @property-read int[] $domainIds
 * @property-read bool $publicTemplate
 * @property-read TemplateRecordManagerInterface $records
 */
class Template extends AbstractModel implements TemplateInterface
{
    /**
     * The record manager for the template.
     * @var TemplateRecordManagerInterface|null
     */
    protected ?TemplateRecordManagerInterface $recordManager = null;
    protected array $props = [
        'name',
        'domainIds',
        'publicTemplate',
    ];

    protected array $editable = [
        'name',
    ];

    /**
     * Returns the record manager for this template.
     * @return TemplateRecordManagerInterface
     */
    protected function getRecords(): TemplateRecordManagerInterface
    {
        if (!$this->recordManager) {
            $this->recordManager = new TemplateRecordManager($this->client);
            $this->recordManager->setDomain($this);
        }
        return $this->recordManager;
    }
}