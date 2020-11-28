<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\UsageManagerInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\UsageInterface;
use DnsMadeEasy\Models\Usage;

/**
 * @package DnsMadeEasy
 */
class UsageManager implements UsageManagerInterface
{
    protected ClientInterface $client;

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