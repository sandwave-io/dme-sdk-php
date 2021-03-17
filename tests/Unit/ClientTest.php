<?php

namespace DnsMadeEasy\Tests\Unit;

use DnsMadeEasy\Client;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\PaginatorFactoryInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface as HttpClientInterface;

class ClientTest extends TestCase
{

    public function testCreateClient(): void
    {
        $client = new Client();

        Assert::assertInstanceOf(HttpClientInterface::class, $client->getHttpClient());
		Assert::assertIsString($client->getEndpoint());
		Assert::assertInstanceOf(PaginatorFactoryInterface::class, $client->getPaginatorFactory());
    }
}
