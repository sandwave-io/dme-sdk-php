<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Api\DomainRecords;

use DnsMadeEasy\Managers\DomainRecordManager;
use DnsMadeEasy\Managers\ManagedDomainManager;
use DnsMadeEasy\Models\ManagedDomain;
use DnsMadeEasy\Models\Record;
use DnsMadeEasy\Pagination\Paginator;
use DnsMadeEasy\Tests\Api\ApiTestCase;
use PHPUnit\Framework\Assert;

class ListDomainRecordsTest extends ApiTestCase
{
    public function testListRecords(): void
    {
        $client = $this->getMockedClient(
            200,
            (string) file_get_contents(__DIR__ . '/data/domain_records_list.json'),
            self::assertRoute('GET', '/V2.0/dns/managed/1119443/records')
        );

        $manager = new DomainRecordManager($client);
        $data = (object) ['id' => 1119443, 'updated' => 0, 'created' => 0];
        $domain = new ManagedDomain($this->createMock(ManagedDomainManager::class), $client, $data);
        $manager->setDomain($domain);
        $records = $manager->paginate(1, 100);

        Assert::assertInstanceOf(Paginator::class, $records);
        Assert::assertEquals(3, $records->count(), 'Unexpected number of records.');
        $record = $records[0];
        Assert::assertInstanceOf(Record::class, $record);
        /** @var Record $record */
        Assert::assertEquals('A', $record->type);
        Assert::assertEquals('208.94.148.2', $record->value);
        Assert::assertEquals('ns1', $record->name);
        Assert::assertEquals(1800, $record->ttl);
        Assert::assertEquals('DEFAULT', $record->gtdLocation);
    }
}
