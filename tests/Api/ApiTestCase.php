<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Api;

use DnsMadeEasy\Client;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

abstract class ApiTestCase extends TestCase
{
    const API_KEY = 'test_key';

    const API_SECRET = 'test_secret';

    const HEADERS = [
        'x-dnsme-requestId' => '999',
        'x-dnsme-requestsRemaining' => '999',
        'x-dnsme-requestLimit' => '999',
    ];

    public function getMockedClient(int $responseCode, string $responseBody, ?callable $assertClosure = null): Client
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response($responseCode, self::HEADERS, $responseBody),
        ]));

        if ($assertClosure !== null) {
            $handlerStack->push(function (callable $handler) use ($assertClosure): callable {
                return function (RequestInterface $request, $options) use ($handler, $assertClosure) {
                    $assertClosure($request);
                    return $handler($request, $options);
                };
            });
        }

        $httpClient = new HttpClient(['handler' => $handlerStack]);
        $client = new Client($httpClient);
        $client->setApiKey(self::API_KEY);
        $client->setSecretKey(self::API_SECRET);
        return $client;
    }

    public static function assertRoute(string $method, string $route): callable
    {
        return function (RequestInterface $request) use ($method, $route): void {
            Assert::assertSame(strtoupper($method), strtoupper($request->getMethod()));
            Assert::assertSame($route, $request->getUri()->getPath());
        };
    }
}
