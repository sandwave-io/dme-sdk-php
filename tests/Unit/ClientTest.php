<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit;

use DnsMadeEasy\Client;
use DnsMadeEasy\Exceptions\Client\Http\BadRequestException;
use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\Http\NotFoundException;
use DnsMadeEasy\Exceptions\Client\ManagerNotFoundException;
use DnsMadeEasy\Managers\ManagedDomainManager;
use DnsMadeEasy\Managers\UsageManager;
use DnsMadeEasy\Pagination\Factories\PaginatorFactory;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\NullLogger;

class ClientTest extends TestCase
{
    const HEADERS = [
        'x-dnsme-requestId' => '999',
        'x-dnsme-requestsRemaining' => '999',
        'x-dnsme-requestLimit' => '999',
    ];

    public function testClientGet(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, self::HEADERS),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setApiKey('apiKey');
        $client->setSecretKey('secretKey');

        $response = $client->get('/test', ['test' => 'test']);
        Assert::assertInstanceOf(Response::class, $response);
        Assert::assertSame('OK', $response->getReasonPhrase(), 'Response reason phrase is not the same as get reason phrase');

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
            new Response(201, self::HEADERS),
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
            new Response(200, self::HEADERS),
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
            new Response(204, self::HEADERS),
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

    public function testClientSend(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, self::HEADERS),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setSecretKey('secretKey');
        $client->setApiKey('secertKey');

        $request = new Request('GET', '/test');
        $response = $client->send($request);

        Assert::assertInstanceOf(Response::class, $response);
        Assert::assertSame('OK', $response->getReasonPhrase(), 'Response reason phrase is not the same as get reason phrase');

        Assert::assertNotNull($client->getLastRequestId(), 'Last request id should be set');
        Assert::assertNotNull($client->getRequestLimit(), 'Request limit should be set');
        Assert::assertNotNull($client->getRequestsRemaining(), 'Request remaining should be set');
    }

    public function testClientSendNotFound(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(404, self::HEADERS),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setSecretKey('secretKey');
        $client->setApiKey('secertKey');

        $request = new Request('GET', '/test', self::HEADERS);
        $this->expectException(NotFoundException::class);
        $client->send($request);
    }

    public function testClientSendBadRequest(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(400, self::HEADERS),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setSecretKey('secretKey');
        $client->setApiKey('secertKey');

        $request = new Request('GET', '/test', self::HEADERS);
        $this->expectException(BadRequestException::class);
        $client->send($request);
    }

    public function testClientSendHttpException(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(500, self::HEADERS),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setSecretKey('secretKey');
        $client->setApiKey('secertKey');

        $request = new Request('GET', '/test', self::HEADERS);
        $this->expectException(HttpException::class);
        $client->send($request);
    }

    public function testClientLimits(): void
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200),
            new Response(200, self::HEADERS),
            new Response(200),
        ]));
        $httpClient = new HttpClient(['handler' => $handlerStack]);

        $client = new Client($httpClient);
        $client->setSecretKey('secretKey');
        $client->setApiKey('secertKey');

        $request = new Request('GET', '/test');
        $client->send($request);

        Assert::assertNull($client->getLastRequestId(), 'Last request id should not be set');
        Assert::assertNull($client->getRequestLimit(), 'Request limit should not be set');
        Assert::assertNull($client->getRequestsRemaining(), 'Request remaining should not be set');

        $client->send($request);
        Assert::assertSame('999', $client->getLastRequestId(), 'Last request id is not the same as set value');
        Assert::assertSame(999, $client->getRequestLimit(), 'Request limit is not the same as set value');
        Assert::assertSame(999, $client->getRequestsRemaining(), 'Requests remaining is not the same as set value');

        $client->send($request);

        Assert::assertNull($client->getLastRequestId(), 'Last request id should not be set');
        Assert::assertNull($client->getRequestLimit(), 'Request limit should not be set');
        Assert::assertNull($client->getRequestsRemaining(), 'Request remaining should not be set');
    }

    public function testClientMagicGet(): void
    {
        $client = new Client();

        $usage = $client->usage;
        Assert::assertInstanceOf(UsageManager::class, $usage, 'usages is not instance of UsageManager');
    }

    public function testClientMagicGetManager(): void
    {
        $client = new Client();

        $domains = $client->domains;
        Assert::assertInstanceOf(ManagedDomainManager::class, $domains, 'domains is not instance of Managed domains');
    }

    public function testClientGetMissingManager(): void
    {
        $client = new Client();

        $this->expectException(ManagerNotFoundException::class);
        /** @phpstan-ignore-next-line */
        $client->missing;
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

        $logger = $this->getMockForAbstractClass(AbstractLogger::class);
        $client->setLogger($logger);
        Assert::assertInstanceOf(AbstractLogger::class, $client->getLogger(), 'Client logger is not instance of set Logger');
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
