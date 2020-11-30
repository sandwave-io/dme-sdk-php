<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Interfaces\Managers\TemplateRecordManagerInterface;

/**
 * Represents a Template resource.
 *
 * @package DnsMadeEasy\Interfaces\Models\Interfaces
 * @property string $name
 * @property-read int[] $domainIds
 * @property-read bool $publicTemplate
 * @property-read TemplateRecordManagerInterface $records
 */
interface TemplateInterface extends AbstractModelInterface
{
}