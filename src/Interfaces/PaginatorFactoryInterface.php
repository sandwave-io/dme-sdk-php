<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces;

interface PaginatorFactoryInterface
{
    public function paginate(array $items, int $totalItems, int $perPage, int $currentPage = 1);
}