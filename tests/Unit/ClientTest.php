<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit;

use DnsMadeEasy\Client;
use DnsMadeEasy\Pagination\Factories\PaginatorFactory;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Psr\Log\Test\TestLogger;

class ClientTest extends TestCase
{
    const HEADER = [
        'x-dnsme-requestId' => '999',
        'x-dnsme-requestsRemaining' => '999',
        'x-dnsme-requestLimit' => '999',
    ];

    public function testClientGet(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, self::HEADER),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setApiKey('apiKey');
        $client->setSecretKey('secretKey');

        $response = $client->get('/test', ['test' => 'test']);
        Assert::assertInstanceOf(Response::class, $response);

        Assert::assertNotNull($client->getLastRequestId(), 'Last request id should be set');
        Assert::assertSame('999', $client->getLastRequestId(), 'Last request id is not the same as set value');

        Assert::assertNotNull($client->getRequestLimit(), 'Request limit should be set');
        Assert::assertSame(999, $client->getRequestLimit(), 'Request limit is not the same as set value');

        Assert::assertNotNull($client->getRequestsRemaining(), 'Request remaining should be set');
        Assert::assertSame(999, $client->getRequestsRemaining(), 'Requests remaining is not the same as set value');
    }

    public function testClientPost(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(201, self::HEADER),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setApiKey('apiKey');
        $client->setSecretKey('secretKey');

        $response = $client->post('/test', ['item' => 'yes']);

        Assert::assertInstanceOf(Response::class, $response);
        Assert::assertSame('Created', $response->getReasonPhrase(), 'Reason phrase is not the same as Post value');

        Assert::assertNotNull($client->getLastRequestId(), 'Last request id should be set');
        Assert::assertNotNull($client->getRequestLimit(), 'Request limit should be set');
        Assert::assertNotNull($client->getRequestsRemaining(), 'Request remaining should be set');
    }

    public function testClientPut(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, self::HEADER),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setSecretKey('secertKey');
        $client->setApiKey('apiKey');

        $response = $client->put('/test/put', ['updated' => 'updated']);
        Assert::assertInstanceOf(Response::class, $response);
        Assert::assertSame('OK', $response->getReasonPhrase(), 'Response reasonphrase is not the same as put reason phrase');

        Assert::assertNotNull($client->getLastRequestId(), 'Last request id should be set');
        Assert::assertNotNull($client->getRequestLimit(), 'Request limit should be set');
        Assert::assertNotNull($client->getRequestsRemaining(), 'Request remaining should be set');
    }

    public function testClientDelete(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(204, self::HEADER),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setApiKey('apiKey');
        $client->setSecretKey('secretKey');

        $response = $client->delete('/test/delete', ['object_id' => 21]);
        Assert::assertInstanceOf(Response::class, $response, 'Response is not instance of guzzle response');
        Assert::assertSame('No Content', $response->getReasonPhrase(), 'Response phrase is not same as deleted response phrase');

        Assert::assertNotNull($client->getLastRequestId(), 'Last request id should be set');
        Assert::assertNotNull($client->getRequestLimit(), 'Request limit should be set');
        Assert::assertNotNull($client->getRequestsRemaining(), 'Request remaining should be set');
    }

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
        $httpClient = new HttpClient();

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
