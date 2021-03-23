<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit\Models;

use DnsMadeEasy\Client;
use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Models\DomainRecord;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DomainRecordTest extends TestCase
{
    public function testDomainRecordReadOnlyProperty(): void
    {
        $client = new Client();
        $domainRecord = new DomainRecord($client->domains, $client);

        $managedDomain = $client->domains->create();
        $managedDomain->name = 'test123.nl';
        //Set initial domain
        $domainRecord->setDomain($managedDomain);

        $newManagedDomain = $client->domains->create();
        $newManagedDomain->name = 'test24.nl';

        $this->expectException(ReadOnlyPropertyException::class);
        //Set second domain should give read only property exception cause the domain was already set once.
        $domainRecord->setDomain($newManagedDomain);
    }

    public function testDomainRecordSetAndGetDomain(): void
    {
        $client = new Client();
        $domainRecord = new DomainRecord($client->domains, $client);

        $managedDomain = $client->domains->create();
        $managedDomain->name = 'test25.nl';
        $managedDomain->populateFromApi((object) [
            'id' => 42,
            'updated' => 0,
            'created' => 0,
        ]);

        Assert::assertNull($domainRecord->getDomain(), 'DomainRecord domain should not be set');
        Assert::assertNull($domainRecord->getDomainId(), 'DomainRecord domainId should not be set');
        $domainRecord->setDomain($managedDomain);
        Assert::assertNotNull($domainRecord->getDomain(), 'Domain record should be set with setted domain');
        Assert::assertSame($managedDomain, $domainRecord->getDomain(), 'DomainRecord should have same domain as created managed domain');
        Assert::assertSame($managedDomain->id, $domainRecord->getDomainId(), 'DomainRecord domain id should be the same as the setted managed domain');
    }
}
