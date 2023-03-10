<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces;

/**
 * A factory for creating paginated collections of items.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface PaginatorFactoryInterface
{
    /**
     * Returns a pagination object based on the supplied parameters.
     *
     * @param mixed[] $items
     */
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1): mixed;
}
