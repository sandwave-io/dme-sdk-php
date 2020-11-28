<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\TemplateInterface;

/**
 * @package DnsMadeEasy\Models
 *
 * @property string $name
 * @property-read int[] $domainIds
 * @property-read bool $publicTemplate
 */
class Template extends AbstractModel implements TemplateInterface
{
    protected array $props = [
        'name',
        'domainIds',
        'publicTemplate',
    ];

    protected array $editable = [
        'name',
    ];
}