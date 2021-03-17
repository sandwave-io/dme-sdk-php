<?php

namespace DnsMadeEasy\Tests\Unit;

use DnsMadeEasy\Client;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    public function testCreateClient(): void
    {
        $client = new Client();

        Assert::assertInstanceOf(Client::class, $client);
    }
}