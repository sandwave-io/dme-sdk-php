<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit\Pagination;

use ArrayIterator;
use DnsMadeEasy\Pagination\Paginator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    public function testPaginationConstruct(): void
    {
        $array = include __DIR__ . '/data/paginator_array.php';

        $paginator = new Paginator($array, count($array), 6, 1);

        Assert::assertTrue(isset($paginator['title']), 'Paginator key has not been set');
        Assert::assertSame('test', $paginator['title'], 'Paginator offset does not have the correct value as set');

        Assert::assertSame(1, $paginator->firstItem(), 'Paginator does not have the same first item as set');
        Assert::assertSame(6, $paginator->perPage(), 'Paginator does not have the same amount per page as set');
        Assert::assertSame(1, $paginator->currentPage(), 'Paginator does not have the currentpage as set');
        Assert::assertSame(2, $paginator->lastPage(), 'Paginator does not have the same last page as set');
        Assert::assertSame(count($array), $paginator->total(), 'Paginator does not have the same count ass set count');
        Assert::assertSame(12, $paginator->lastItem(), 'Paginator does not have te set last item count');

        Assert::assertTrue($paginator->offsetExists('test1'), 'Paginator offset should exist');
        $paginator->offsetSet('test2', 'testing123');
        Assert::assertTrue($paginator->offsetExists('test2'), 'Paginator offset should exist');
        Assert::assertSame('testing123', $paginator->offsetGet('test2'), 'Paginator offset is not the same as set value');

        $paginator->offsetUnset('test11');
        Assert::assertArrayNotHasKey('test11', $paginator, 'Key has not been unset properly');
        Assert::assertTrue($paginator->hasMorePages(), 'Paginator does not have more pages');
        Assert::assertInstanceOf(ArrayIterator::class, $paginator->getIterator(), 'Paginator iterator class is not instance of Array iterator');
    }
}
