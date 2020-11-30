<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\UsageManagerInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Models\Usage;

/**
 * Manager for query usage.
 * @package DnsMadeEasy\Managers
 */
class UsageManager implements UsageManagerInterface
{
    protected ClientInterface $client;

    /**
     * Createsa new Query Usage manager.
     * @internal
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function all(): array {
        return $this->getData('/usageApi/queriesApi');
    }

    public function forMonth(int $year, int $month): array
    {
        return $this->getData("/usageApi/queriesApi/{$year}/{$month}");
    }

    public function forDomain(CommonManagedDomainInterface $domain, int $year, int $month): array
    {
        return $this->forDomainId($domain->id, $year, $month);
    }

    public function forDomainId(int $domainId, int $year, int $month): array
    {
        return $this->getData("/usageApi/queriesApi/{$year}/{$month}/managed/{$domainId}", $domainId);
    }

    /**
     * Returns the data from the API for the usage requested.
     * @param string $url
     * @param int|null $domainId
     * @return array
     * @throws HttpException
     */
    protected function getData(string $url, ?int $domainId = null): array
    {
        $response = $this->client->get($url);
        $data = json_decode((string) $response->getBody());
        return array_map(function ($item) use ($domainId) {
            $item->domainId = $domainId;
            return new Usage($this->client, $this, $item);
        }, $data);
    }
}