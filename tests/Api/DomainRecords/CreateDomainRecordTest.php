<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Api\DomainRecords;

use DnsMadeEasy\Enums\GTDLocation;
use DnsMadeEasy\Enums\RecordType;
use DnsMadeEasy\Managers\DomainRecordManager;
use DnsMadeEasy\Managers\ManagedDomainManager;
use DnsMadeEasy\Models\DomainRecord;
use DnsMadeEasy\Models\ManagedDomain;
use DnsMadeEasy\Tests\Api\ApiTestCase;
use PHPUnit\Framework\Assert;

class CreateDomainRecordTest extends ApiTestCase
{
    public function testCreateDomainRecord(): void
    {
        $createRecordClient = $this->getMockedClient(
            200,
            (string) file_get_contents(__DIR__ . '/data/domain_record_create_success.json'),
            self::assertRoute('POST', '/V2.0/dns/managed/1119443/records')
        );

        $domainRecordManager = new DomainRecordManager($createRecordClient);

        $data = (object) [ 'id' => 1119443, 'updated' => 1504807431610, 'created' => 1504807431610];
        $domain = new ManagedDomain($this->createMock(ManagedDomainManager::class), $createRecordClient, $data);

        $domainRecordManager->setDomain($domain);
        $record = $domainRecordManager->create();
        $record->name = 'mail';
        $record->type = RecordType::A();
        $record->value = '192.168.1.1';
        $record->gtdLocation = GTDLocation::DEFAULT();
        $record->ttl = 86400;
        $record->save();
        Assert::assertInstanceOf(DomainRecord::class, $record);
    }
}
