<?php
declare(strict_types=1);

namespace DnsMadeEasy\Pagination\Helpers;

use DnsMadeEasy\Pagination\Paginator;

class PaginatorHelper
{
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1): Paginator
    {
        return new Paginator($items, $totalItems, $perPage, $currentPage);
    }
}