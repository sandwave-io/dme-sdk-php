<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers\Multiple;

use DnsMadeEasy\Enums\GTDLocation;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\MultipleRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Models\DomainRecord;

/**
 * Manages multiple domain records at once.
 *
 * @package DnsMadeEasy\Managers
 */
class MultipleRecordManager implements MultipleRecordManagerInterface
{
    /**
     * The DNS Made Easy API Client.
     *
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * The domain to manage records for.
     *
     * @var CommonManagedDomainInterface
     */
    protected CommonManagedDomainInterface $domain;

    /**
     * The base URI for managed domains.
     *
     * @var string
     */
    protected string $baseUri = '/dns/managed';

    public function __construct(ClientInterface $client, CommonManagedDomainInterface $domain)
    {
        $this->client = $client;
        $this->domain = $domain;
        $this->baseUri = "/dns/managed/{$domain->id}/records";
    }

    public function create(array $records): array
    {
        $payload = [];
        foreach ($records as $record) {
            // We only handle Domain Records
            if (! $record instanceof DomainRecordInterface) {
                continue;
            }

            // We only work on new records
            if ($record->id) {
                continue;
            }
            if (! $record->gtdLocation) {
                $record->gtdLocation = GTDLocation::DEFAULT();
            }
            $payload[] = $record->transformForApi();
        }

        if (! $payload) {
            return [];
        }

        $response = $this->client->post($this->baseUri . '/createMulti', $payload);
        $data = json_decode((string) $response->getBody());
        $result = [];
        foreach ($data as $recordData) {
            $result[] = new DomainRecord($this->client->domains, $this->client, $recordData);
        }
        return $result;
    }

    public function update(array $records): void
    {
        $payload = [];
        foreach ($records as $record) {
            // We only handle Domain Records
            if (! $record instanceof DomainRecordInterface) {
                continue;
            }

            // We only work on exsiting records
            if (! $record->id) {
                continue;
            }
            $payload[] = $record->transformForApi();
        }
        $this->client->put($this->baseUri . '/updateMulti', $payload);
    }

    public function delete(array $ids): void
    {
        $uri = "{$this->baseUri}?";
        foreach ($ids as $id) {
            if (is_numeric($id)) {
                $uri .= "ids={$id}&";
            }
        }
        if ($uri == "{$this->baseUri}?") {
            return;
        }

        $this->client->delete($uri);

        foreach ($ids as $id) {
            $this->domain->records->removeFromCache("DomainRecord:{$id}");
        }
    }
}
