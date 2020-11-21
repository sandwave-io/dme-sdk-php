<?php
declare(strict_types=1);

namespace DnsMadeEasy\Pagination\Factories;

use DnsMadeEasy\Interfaces\PaginatorFactoryInterface;
use \Illuminate\Pagination\LengthAwarePaginator;

class IlluminatePaginatorFactory implements PaginatorFactoryInterface
{
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1)
    {
        return new LengthAwarePaginator($items, $totalItems, $perPage, $currentPage);
    }
}