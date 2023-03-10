<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers\Multiple;

use DnsMadeEasy\Exceptions\DnsMadeEasyException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\MultipleDomainManagerInterface;

/**
 * Manages multiple domains.
 *
 * @package DnsMadeEasy\Managers
 */
class MultipleDomainManager implements MultipleDomainManagerInterface
{
    /**
     * The DNS Made Easy API Client.
     */
    protected ClientInterface $client;

    /**
     * The URI for managed domains.
     */
    protected string $baseUri = '/dns/managed';

    /**
     * Properties that are valid for being set on multiple domains.
     *
     * @var string[]
     */
    protected array $validProperties = [
        'gtdEnabled',
        'folderId',
        'vanityId',
        'transferAclId',
        'templateId',
    ];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function create(array $domainNames, ?object $properties = null): array
    {
        if (count($domainNames) === 0) {
            return [];
        }

        $payload = $this->getPayload($properties);
        $payload->names = $domainNames;

        $response = $this->client->post($this->baseUri, $payload);
        $data = json_decode((string) $response->getBody());
        if (is_array($data)) {
            // We have an array of IDs
            return $data;
        } elseif (is_object($data)) {
            // We have an object back, return the ID
            return [$data->id];
        }
        throw new DnsMadeEasyException('Unexpected response to object creation: ' . $data);
    }

    public function update(array $ids, ?object $properties = null): void
    {
        if (count($ids) === 0) {
            return;
        }

        $payload = $this->getPayload($properties);
        $payload->ids = $ids;

        $this->client->put($this->baseUri, $payload);
    }

    public function delete(array $ids): void
    {
        if (count($ids) === 0) {
            return;
        }

        $this->client->delete($this->baseUri, $ids);

        foreach ($ids as $id) {
            $this->client->domains->removeFromCache("ManagedDomain:{$id}");
        }
    }

    /**
     * Gets the payload based on the supplied properties.
     */
    protected function getPayload(?object $properties = null): object
    {
        $payload = new \stdClass();
        if ($properties === null) {
            return $payload;
        }

        foreach ($this->validProperties as $propName) {
            if (property_exists($properties, $propName)) {
                $payload->{$propName} = $properties->{$propName};
            }
        }

        return $payload;
    }
}
