<?php
declare(strict_types=1);

namespace DnsMadeEasy\Pagination\Factories;

use DnsMadeEasy\Interfaces\PaginatorFactoryInterface;
use DnsMadeEasy\Pagination\Paginator;

class PaginatorFactory implements PaginatorFactoryInterface
{
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1)
    {
        return new Paginator($items, $totalItems, $perPage, $currentPage);
    }
}