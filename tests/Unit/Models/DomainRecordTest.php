<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit\Models;

use DnsMadeEasy\Client;
use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Exceptions\DnsMadeEasyException;
use DnsMadeEasy\Models\DomainRecord;
use DnsMadeEasy\Models\RecordFailover;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
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

    public function testDomainRecordFallbackException(): void
    {
        $client = new Client();
        $domainRecord = new DomainRecord($client->domains, $client);

        $this->expectException(DnsMadeEasyException::class);
        $domainRecord->getRecordFailover();
    }

    public function testDomainRecordFallback(): void
    {
        $handlerStack = new HandlerStack(new MockHandler([
            new Response(200, [], (string) file_get_contents(__DIR__ . '/data/failover_get.json')),
        ]));

        $httpClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);
        $client = new Client($httpClient);
        $client->setSecretKey('secretKey');
        $client->setApiKey('apiKey');

        $client->failover->get(111);

        $domainRecord = new DomainRecord($client->domains, $client, (object) ['id' => 111, 'failover' => true]);
        $failoverRecord = $domainRecord->getRecordFailover();

        Assert::assertInstanceOf(RecordFailover::class, $failoverRecord, 'RecordFailover is not instance of Record failover');
        Assert::assertSame(111, $failoverRecord->recordId, 'RecordFailover record id is not the same as set RecordID');
        Assert::assertFalse($failoverRecord->autoFailover, 'RecordFailover autoFailover should be false');

        Assert::assertSame('192.168.1.2', $failoverRecord->ip1, 'RecordFailover Ip1 is not the same as set ip1');
        Assert::assertSame(2, $failoverRecord->ip1Failed, 'RecordFailover ip1Failed is not the same as set value');
        Assert::assertSame(2, $failoverRecord->ip2Failed, 'RecordFailover ip2failed is not the same as set value');
        Assert::assertSame('10.10.10.11', $failoverRecord->ip2, 'RecordFailover ip2 is no the same as set ip2');

        Assert::assertSame(5, $failoverRecord->sensitivity, 'RecordFailover is not the same as set sensitivity');
        Assert::assertSame(1, $failoverRecord->maxEmails, 'RecordFailover max emails is not the same as set max emails');
        Assert::assertSame(1119443, $failoverRecord->sourceId, 'RecordFailover sourceId is not the same as set SourceId');
    }
}
