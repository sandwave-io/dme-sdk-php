<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Common;

use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\UsageInterface;

/**
 * Represents the properties and methods common between full ManagedDomain and concise ManagedDomain objects. For use
 * when you only need these basic properties and methods.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface CommonManagedDomainInterface extends AbstractModelInterface
{
    /**
     * Create a new template based on this domain.
     * @param string $name
     * @return TemplateInterface
     */
    public function createTemplate(string $name): TemplateInterface;

    /**
     * Get query usage for the domain.
     * @param int $year
     * @param int $month
     * @return UsageInterface[]
     */
    public function getUsage(int $year, int $month): array;
}