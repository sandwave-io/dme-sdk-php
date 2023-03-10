<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Pagination\Factories;

use DnsMadeEasy\Interfaces\PaginatorFactoryInterface;
use DnsMadeEasy\Pagination\Paginator;

/**
 * Factory for Paginator objects.
 *
 * @package DnsMadeEasy\Pagination
 */
class PaginatorFactory implements PaginatorFactoryInterface
{
    /**
     * Returns a paginator based on the supplied items and parameters.
     *
     * @param mixed[] $items
     */
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1): Paginator
    {
        return new Paginator($items, $totalItems, $perPage, $currentPage);
    }
}
