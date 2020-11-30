<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\Http\NotFoundException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;

/**
 * Abstract class for a resource manager.
 * @package DnsMadeEasy\Managers
 */
abstract class AbstractManager implements AbstractManagerInterface
{
    /**
     * The Dns Made Easy API Client.
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * The URI for the resource.
     * @var string
     */
    protected string $baseUri;

    /**
     * A cache of objects fetched from the API.
     * @var AbstractModelInterface[]
     */
    protected array $objectCache = [];

    /**
     * Fetches an object from the cache, or if not found, from the API.
     * @param int $id
     * @return AbstractModelInterface
     * @throws ModelNotFoundException
     * @throws HttpException
     * @throws \ReflectionException
     */
    protected function getObject(int $id): AbstractModelInterface
    {
        $objectId = $this->getObjectId($id);
        if ($this->getFromCache($objectId)) {
            return $this->getFromCache($objectId);
        }

        $data = $this->getFromApi($id);
        return $this->createExistingObject($data, $this->getModelClass());
    }

    /**
     * Get the object from the API.
     * @param int $id
     * @return object
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    protected function getFromApi(int $id): object
    {
        $uri = $this->getObjectUri($id);
        try {
            $response = $this->client->get($uri);
        } catch (NotFoundException $e) {
            throw new ModelNotFoundException("Unable to find object with ID {$id}");
        }
        $data = json_decode((string)$response->getBody());
        return $this->transformApiData($data);
    }

    /**
     * Create a new object.
     * @param string|null $className
     * @return AbstractModelInterface
     */
    protected function createObject(?string $className = null): AbstractModelInterface
    {
        if (!$className) {
            $className = $this->getModelClass();
        }
        return new $className($this, $this->client);
    }

    /**
     * Deletes the object passed to it. If the object doesn't have an ID, no action is taken. The object is also
     * removed from the cache.
     * @param AbstractModelInterface $object
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     * @internal
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
     * Saves the object passed to it.
     * @param AbstractModelInterface $object
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     * @internal
     */
    public function save(AbstractModelInterface $object): void
    {
        if ($object->id) {
            $this->client->put($this->getObjectUri($object->id), $object->transformForApi());
        } else {
            $response = $this->client->post($this->getBaseUri(), $object->transformForApi());
            $data = json_decode((string)$response->getBody());
            $object->populateFromApi($data);
        }
    }

    /**
     * Constructor for a Manager class.
     * @param ClientInterface $client
     * @internal
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Fetches the base URI for the resource.
     * @return string
     */
    protected function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * Fetches the URI for a resource with the specified ID.
     * @param int $id
     * @return string
     */
    protected function getObjectUri(int $id): string
    {
        return "{$this->getBaseUri()}/{$id}";
    }

    /**
     * Return the name of the model class for this resource.
     * @return string
     * @throws \ReflectionException
     */
    protected function getModelClass(): string
    {
        $rClass = new \ReflectionClass($this);
        $modelName = substr($rClass->getShortName(), 0, -7);
        return '\DnsMadeEasy\Models\\' . $modelName;
    }

    /**
     * Return the name of the model class for the concise version of the resource.
     * @return string
     * @throws \ReflectionException
     */
    protected function getConciseModelClass(): string
    {
        return $this->getModelClass();
    }

    /**
     * Returns a string ID to give a unique ID to this resource.
     * @param $input
     * @param string|null $name
     * @return string
     * @throws \ReflectionException
     */
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
        return "{$name}:" . (string)$input;
    }

    /**
     * Creates a new instance of an object from existing API data.
     * @param object $data
     * @param string $className
     * @return AbstractModelInterface
     * @throws \ReflectionException
     */
    protected function createExistingObject(object $data, string $className): AbstractModelInterface
    {
        $objectId = $this->getObjectId($data, $className);
        if ($this->getFromCache($objectId)) {
            return $this->getFromCache($objectId);
        }

        $object = $this->createObject($className);
        $object->populateFromApi($data);

        $this->putInCache($objectId, $object);

        return $object;
    }

    /**
     * Fetch the object from the local cache.
     * @param $key
     * @return AbstractModelInterface
     */
    protected function getFromCache($key)
    {
        if (array_key_exists($key, $this->objectCache)) {
            $this->client->logger->debug("[DnsMadeEasy] Object Cache: Fetching {$key}");
            return $this->objectCache[$key];
        }
    }

    /**
     * Put the object into the local cache.
     * @param $key
     * @param $object
     */
    protected function putInCache($key, $object)
    {
        $this->client->logger->debug("[DnsMadeEasy] Object Cache: Putting {$key}");
        $this->objectCache[$key] = $object;
    }

    /**
     * Remove the object from the local cache.
     * @param $object
     */
    protected function removeFromCache($object)
    {
        $index = array_search($object, $this->objectCache);
        if ($index !== false) {
            $this->client->logger->debug("[DnsMadeEasy] Object Cache: Removing {$index}");
            unset($this->objectCache[$index]);
        }
    }

    /**
     * Updates the object to the latest version in the API.
     * @param AbstractModelInterface $object
     * @throws ModelNotFoundException
     * @internal
     */
    public function refresh(AbstractModelInterface $object): void
    {
        if (!$object->id) {
            return;
        }

        $data = $this->getFromApi($object->id);
        $object->populateFromApi($data);
    }

    /**
     * Applies transformations to the API data before it is used to instantiate a model.
     * @param object $data
     * @return object
     */
    protected function transformApiData(object $data): object
    {
        return $data;
    }

    /**
     * Applies transformations to the concise API data before it is used to instantiate a model.
     * @param object $data
     * @return object
     */
    protected function transformConciseApiData(object $data): object
    {
        return $this->transformApiData($data);
    }
}