<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\BadRequestException;
use DnsMadeEasy\Exceptions\Client\Http\NotFoundException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;

abstract class AbstractManager implements AbstractManagerInterface
{
    protected ClientInterface $client;
    protected string $baseUri;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function paginate(int $page = 1, int $perPage = 20)
    {
        $params = [
            'page' => $page,
            'rows' => $perPage,
        ];
        $response = $this->client->get($this->getBaseUri(), $params);
        $data = json_decode((string) $response->getBody());
        $items = array_map(function ($data) {
            $object = $this->createObject();
            $object->populateFromApi($data);
            return $object;
        }, $data->data);

        return $this->client->getPaginatorFactory()->paginate($items, $data->totalRecords, $perPage, $page);
    }

    protected function getBaseUri(): string
    {
        return $this->baseUri;
    }

    protected function getObjectUri(int $id): string
    {
        return "{$this->getBaseUri()}/{$id}";
    }

    public function get(int $id): AbstractModelInterface
    {
        $uri = $this->getObjectUri($id);
        try {
            $response = $this->client->get($uri);
        } catch (NotFoundException $e) {
            throw new ModelNotFoundException("Unable to find object with ID {$id}");
        }
        $data = json_decode((string) $response->getBody());
        $object = $this->createObject();
        $object->populateFromApi($data);
        return $object;
    }

    public function delete(AbstractModelInterface $object): void
    {
        $id = $object->getId();
        if (!$id) {
            return;
        }
        $uri = $this->getObjectUri($id);
        $this->client->delete($uri);
    }

    public function save(AbstractModelInterface $object): void
    {
        try {
            if ($object->getId()) {
                $this->client->put($this->getObjectUri($object->getId()), $object->transformForApi());
            } else {
                $response = $this->client->post($this->getBaseUri(), $object->transformForApi());
                $data = json_decode((string) $response->getBody());
                $object->populateFromApi($data);
            }
        } catch (BadRequestException $e) {
            print_r($e->getResponse()->getStatusCode());
            print_r((string) $e->getResponse()->getBody());
        }
    }
}