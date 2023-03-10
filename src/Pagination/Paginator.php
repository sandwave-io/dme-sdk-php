<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Pagination;

use ArrayIterator;
use Traversable;

/**
 * Simple object paginator. Can be iterated over, accessed like an array and used in a similar manner to Illuminate's
 * LengthAwarePaginator.
 *
 * @package DnsMadeEasy\Pagination
 */
class Paginator implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /** @var mixed[] */
    protected array $items;

    protected int $totalItems;

    protected int $perPage;

    protected int $currentPage;

    protected int $lastPage;

    /**
     * Creates a new Paginator.
     *
     * @param mixed[] $items
     */
    public function __construct(array $items, int $totalItems, int $perPage, int $currentPage = 1)
    {
        $this->items = $items;
        $this->totalItems = $totalItems;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage = max((int) ceil($totalItems / $perPage), 1);
    }

    /**
     * Returns true if the specified offset exists in the items.
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * Get the item at the specified offset.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * Sets the item at the specified offset.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items[$offset] = $value;
    }

    /**
     * Removes the item at the specified offset.
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * Gets the number of items in the current page.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Gets the items in the current page.
     *
     * @return mixed[]
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * Get the index of the first item in the page.
     */
    public function firstItem(): ?int
    {
        if ($this->count() > 0) {
            return ($this->currentPage - 1) * $this->perPage + 1;
        }
        return null;
    }

    /**
     * Get the index of the last item in the page.
     */
    public function lastItem(): ?int
    {
        if ($this->count() > 0) {
            $offset = $this->firstItem() ?? 0;
            return $offset + $this->count() - 1;
        }
        return null;
    }

    /**
     * Get the current number of items per page in the pagination.
     */
    public function perPage(): int
    {
        return $this->perPage;
    }

    /**
     * Get the total number of items we are paginating through.
     */
    public function total(): int
    {
        return $this->totalItems;
    }

    /**
     * Get the number of the last page.
     */
    public function lastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * Get the number of the current page.
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Return true if this is the first page.
     */
    public function onFirstPage(): bool
    {
        return $this->currentPage() <= 1;
    }

    /**
     * Return true if there are more pages after this page.
     */
    public function hasMorePages(): bool
    {
        return $this->currentPage() < $this->lastPage();
    }

    /**
     * Fetch an iterator for the items in the page. Allows the paginator to be iterated through.
     *
     * @return Traversable<mixed>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items());
    }
}
