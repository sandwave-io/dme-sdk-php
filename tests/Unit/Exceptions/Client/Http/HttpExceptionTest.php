<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit\Exceptions\Client\Http;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class HttpExceptionTest extends TestCase
{
    public function testSettersAndGetters(): void
    {
        $exception = new HttpException();
        Assert::assertNull($exception->getRequest(), 'request should not be set');
        Assert::assertNull($exception->getResponse(), 'response should not be set');

        $exception->setRequest(new Request('GET', '/test'));
        Assert::assertNotNull($exception->getRequest(), 'request should be set');
        Assert::assertSame('/test', $exception->getRequest()->getUri()->getPath(), 'request should be the same as has been set');

        $exception->setResponse(new Response(200));
        Assert::assertNotNull($exception->getResponse(), 'response should be set');
    }
}
