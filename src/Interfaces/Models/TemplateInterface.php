<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Template resource.
 *
 * @package DnsMadeEasy\Interfaces\Models\Interfaces
 * @property string $name
 * @property-read int[] $domainIds
 * @property-read bool $publicTemplate
 */
interface TemplateInterface extends AbstractModelInterface
{
}