<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Models\TemplateInterface;

/**
 * @package DnsMadeEasy
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