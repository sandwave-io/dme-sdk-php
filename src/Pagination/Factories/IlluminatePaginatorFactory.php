<?php
declare(strict_types=1);

namespace DnsMadeEasy\Pagination\Factories;

use DnsMadeEasy\Interfaces\PaginatorFactoryInterface;
use \Illuminate\Pagination\LengthAwarePaginator;

/**
 * A pagination factory for use with Laravel/Lumen frameworks or anything that is also using the Illuminate pagination
 * libraries.
 * @package DnsMadeEasy
 */
class IlluminatePaginatorFactory implements PaginatorFactoryInterface
{
    /**
     * Returns a LengthAwarePaginator for the items and paramters.
     * @param array $items
     * @param int $totalItems
     * @param int $perPage
     * @param int $currentPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1)
    {
        return new LengthAwarePaginator($items, $totalItems, $perPage, $currentPage);
    }
}