<?php
declare(strict_types=1);

namespace DnsMadeEasy\Pagination;

class Paginator implements \ArrayAccess, \Countable
{
    protected array $items;
    protected int $totalItems;
    protected int $perPage;
    protected int $currentPage;
    protected int $lastPage;

    public function __construct(array $items, int $totalItems, int $perPage, int $currentPage = 1)
    {
        $this->items = $items;
        $this->totalItems = $totalItems;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage = max((int) ceil($totalItems / $perPage), 1);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function count()
    {
        return count($this->items);
    }

    public function items(): array
    {
        return $this->items;
    }

    public function firstItem(): ?int
    {
        if (count($this->items) > 0) {
            return ($this->currentPage - 1) * $this->perPage + 1;
        }
        return null;
    }

    public function lastItem(): ?int
    {
        if (count($this->items) > 0) {
            return $this->firstItem() + $this->count() - 1;
        }
        return null;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function total(): int
    {
        return $this->totalItems;
    }

    public function lastPage(): int
    {
        return $this->lastPage;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function onFirstPage(): bool
    {
        return $this->currentPage() <= 1;
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage() < $this->lastpage();
    }
}