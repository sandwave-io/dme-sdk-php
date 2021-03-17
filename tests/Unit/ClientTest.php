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

        Assert::assertSame('https://api.dnsmadeeasy.com/V2.0', $client->getEndpoint());
    }
}
