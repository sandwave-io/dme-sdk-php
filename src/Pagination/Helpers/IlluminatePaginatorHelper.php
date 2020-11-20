<?php
declare(strict_types=1);

namespace DnsMadeEasy\Pagination\Helpers;

use \Illuminate\Pagination\LengthAwarePaginator;

class IlluminatePaginatorHelper extends AbstractPaginatorHelper
{
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1): LengthAwarePaginator
    {
        return new LengthAwarePaginator($items, $totalItems, $perPage, $currentPage);
    }
}