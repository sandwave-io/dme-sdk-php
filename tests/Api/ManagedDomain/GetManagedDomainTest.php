<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Api\ManagedDomain;

use DnsMadeEasy\Models\ManagedDomain;
use DnsMadeEasy\Tests\Api\ApiTestCase;
use PHPUnit\Framework\Assert;

class GetManagedDomainTest extends ApiTestCase
{
    public function testGetDomain(): void
    {
        $client = $this->getMockedClient(
            200,
            (string) file_get_contents(__DIR__ . '/data/managed_domain_get_success.json'),
            self::assertRoute('GET', '/V2.0/dns/managed/1119443')
        );

        $domain = $client->domains->get(1119443);
        Assert::assertInstanceOf(ManagedDomain::class, $domain);

        /** @var ManagedDomain $domain */
        Assert::assertEquals(1119443, $domain->id);
        Assert::assertEquals('exampledomain.com', $domain->name);

        $delegateNameservers = $domain->delegateNameServers;
        Assert::assertCount(2, $delegateNameservers);
        Assert::assertContains('ns1.namefind.com.', $delegateNameservers);
        Assert::assertContains('ns2.namefind.com.', $delegateNameservers);

        $nameservers = $domain->nameServers;
        Assert::assertCount(5, $nameservers);
        /** @var \stdClass $nameserver */
        $nameserver = $nameservers[0];
        Assert::assertSame('2600:1800:0::1', $nameserver->ipv6);
        Assert::assertSame('208.94.148.2', $nameserver->ipv4);
        Assert::assertSame('ns0.dnsmadeeasy.com', $nameserver->fqdn);
    }
}
