<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\BadRequestException;
use DnsMadeEasy\Exceptions\Client\Http\NotFoundException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;

/**
 * @internal
 * @package DnsMadeEasy\Managers
 */
abstract class AbstractManager implements AbstractManagerInterface
{
    protected ClientInterface $client;
    protected string $baseUri;
    protected array $objectCache = [];

    public function paginate(int $page = 1, int $perPage = 20)
    {
        $params = [
            'page' => $page,
            'rows' => $perPage,
        ];
        $response = $this->client->get($this->getBaseUri(), $params);
        $data = json_decode((string) $response->getBody());
        $items = array_map(function ($data) {
            $data = $this->transformConciseApiData($data);
            return $this->createExistingObject($data, $this->getConciseModelClass());;
        }, $data->data);

        return $this->client->getPaginatorFactory()->paginate($items, $data->totalRecords, $perPage, $page);
    }

    protected function getObject(int $id): AbstractModelInterface
    {
        $objectId = $this->getObjectId($id);
        if ($this->getFromCache($objectId)) {
            return $this->getFromCache($objectId);
        }

        $data = $this->getFromApi($id);
        return $this->createExistingObject($data, $this->getModelClass());
    }

    protected function getFromApi(int $id): object
    {
        $uri = $this->getObjectUri($id);
        try {
            $response = $this->client->get($uri);
        } catch (NotFoundException $e) {
            throw new ModelNotFoundException("Unable to find object with ID {$id}");
        }
        $data = json_decode((string) $response->getBody());
        return $this->transformApiData($data);
    }

    protected function createObject(): AbstractModelInterface
    {
        $className = $this->getModelClass();
        return new $className($this, $this->client);
    }

    /**
     * @internal
     * @param AbstractModelInterface $object
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     */
    public function delete(AbstractModelInterface $object): void
    {
        $id = $object->id;
        if (!$id) {
            return;
        }
        $uri = $this->getObjectUri($id);
        $this->client->delete($uri);
        $this->removeFromCache($object);
    }

    /**
     * @internal
     * @param AbstractModelInterface $object
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     */
    public function save(AbstractModelInterface $object): void
    {
        try {
            if ($object->id) {
                $this->client->put($this->getObjectUri($object->id), $object->transformForApi());
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

    /**
     * AbstractManager constructor.
     * @internal
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    protected function getBaseUri(): string
    {
        return $this->baseUri;
    }

    protected function getObjectUri(int $id): string
    {
        return "{$this->getBaseUri()}/{$id}";
    }

    // Methods to help with ORM and Model instantiation

    protected function getModelClass(): string
    {
        $rClass = new \ReflectionClass($this);
        $modelName = substr($rClass->getShortName(), 0, -7);
        return '\DnsMadeEasy\Models\\' . $modelName;
    }

    protected function getConciseModelClass(): string
    {
        return $this->getModelClass();
    }

    protected function getObjectId($input, string $name = null)
    {
        if ($name === null) {
            $name = $this->getModelClass();
        }

        $rClass = new \ReflectionClass($name);
        $name = $rClass->getShortName();
        if (is_scalar($input)) {
            return "{$name}:{$input}";
        } elseif (is_object($input) && property_exists($input, 'id')) {
            return "{$name}:{$input->id}";
        } elseif (is_array($input) && array_key_exists($input, 'id')) {
            return "{$name}:{$input['id']}";
        }
    }

    protected function createExistingObject(object $data, string $className): AbstractModelInterface
    {
        $objectId = $this->getObjectId($data, $className);
        if ($this->getFromCache($objectId)) {
            return $this->getFromCache($objectId);
        }

        $object = new $className($this, $this->client);
        $object->populateFromApi($data);

        $this->putInCache($objectId, $object);

        return $object;

    }

    protected function getFromCache($key)
    {
        if (array_key_exists($key, $this->objectCache)) {
            $this->client->logger->debug("[DnsMadeEasy] Object Cache: Fetching {$key}");
            return $this->objectCache[$key];
        }
    }

    protected function putInCache($key, $object)
    {
        $this->client->logger->debug("[DnsMadeEasy] Object Cache: Putting {$key}");
        $this->objectCache[$key] = $object;
    }

    protected function removeFromCache($object)
    {
        $index = array_search($object, $this->objectCache);
        if ($index !== false) {
            $this->client->logger->debug("[DnsMadeEasy] Object Cache: Removing {$index}");
            unset($this->objectCache[$index]);
        }
    }

    /**
     * @internal
     * @param AbstractModelInterface $object
     * @throws ModelNotFoundException
     */
    public function refresh(AbstractModelInterface $object): void
    {
        if (!$object->id) {
            return;
        }

        $data = $this->getFromApi($object->id);
        $object->populateFromApi($data);
    }

    protected function transformApiData(object $data): object
    {
        return $data;
    }

    protected function transformConciseApiData(object $data): object
    {
        return $this->transformApiData($data);
    }
}