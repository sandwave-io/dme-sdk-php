<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Api\ManagedDomain;

use DnsMadeEasy\Models\ManagedDomain;
use DnsMadeEasy\Tests\Api\ApiTestCase;
use PHPUnit\Framework\Assert;

class CreateManagedDomainTest extends ApiTestCase
{
    public function testCreateDomain(): void
    {
        $client = $this->getMockedClient(
            200,
            (string) file_get_contents(__DIR__ . '/data/managed_domain_create_success.json'),
            self::assertRoute('POST', '/V2.0/dns/managed')
        );

        $domain = $client->domains->create();
        Assert::assertInstanceOf(ManagedDomain::class, $domain);
        $domain->name = 'exampledomain1.com';
        $domain->save();
    }
}
