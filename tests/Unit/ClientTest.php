<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit;

use DnsMadeEasy\Client;
use DnsMadeEasy\Pagination\Factories\PaginatorFactory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Psr\Log\Test\TestLogger;

class ClientTest extends TestCase
{
    public function testGetterAndSetterEndpoint(): void
    {
        $client = new Client();
        Assert::assertSame('https://api.dnsmadeeasy.com/V2.0', $client->getEndpoint());

        $client->setEndpoint('/test');
        Assert::assertSame('/test', $client->getEndpoint(), 'Client endpoint is not the same as set endpoint');
    }

    public function testGetterAndSetterApiKey(): void
    {
        $client = new Client();

        $client->setApiKey('apiKey');
        Assert::assertSame('apiKey', $client->getApiKey(), 'ApiKey is not the same as set ApiKey.');
    }

    public function testGetterAndSetterSecretKey(): void
    {
        $client = new Client();

        $client->setSecretKey('secretKey');
        Assert::assertSame('secretKey', $client->getSecretKey(), 'SecretKey is not the same as set SecretKey.');
    }

    public function testGetterAndSetterClientLogger(): void
    {
        $client = new Client();
        Assert::assertInstanceOf(NullLogger::class, $client->getLogger(), 'Client logger should be NullLogger if not set');

        $logger = new TestLogger();
        $client->setLogger($logger);
        Assert::assertInstanceOf(TestLogger::class, $client->getLogger(), 'Client logger is not instance of set Logger');
    }

    public function testGetClientPaginator(): void
    {
        $client = new Client();
        $paginatorFactory = new PaginatorFactory();

        $client->setPaginatorFactory($paginatorFactory);
        Assert::assertSame($paginatorFactory, $client->getPaginatorFactory());
    }

    public function testGetAndSetHttpClient(): void
    {
        $client = new Client();
        $httpClient = new \GuzzleHttp\Client();

        $client->setHttpClient($httpClient);
        Assert::assertSame($httpClient, $client->getHttpClient(), 'HttpClient on client is not the setted httpclient');
    }

    public function testClientRequestProperty(): void
    {
        $client = new Client();

        Assert::assertNull($client->getLastRequestId(), 'Last request should not be set');
        Assert::assertNull($client->getRequestLimit(), 'Request limit should not be set');
        Assert::assertNull($client->getRequestsRemaining(), 'Remaining request should not be set');
    }
}
