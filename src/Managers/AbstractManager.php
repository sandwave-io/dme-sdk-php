<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\Http\NotFoundException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use ReflectionException;

/**
 * Abstract class for a resource manager.
 *
 * @package DnsMadeEasy\Managers
 */
abstract class AbstractManager implements AbstractManagerInterface
{
    /**
     * The Dns Made Easy API Client.
     */
    protected ClientInterface $client;

    /**
     * The URI for the resource.
     */
    protected string $baseUri;

    /**
     * A cache of objects fetched from the API.
     *
     * @var AbstractModelInterface[]
     */
    protected array $objectCache = [];

    /**
     * Model namespace associated with the manager.
     *
     * @var class-string
     */
    protected string $model;

    /**
     * Constructor for a Manager class.
     *
     * @internal
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Deletes the object passed to it. If the object doesn't have an ID, no action is taken. The object is also
     * removed from the cache.
     *
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     *
     * @internal
     */
    public function delete(AbstractModelInterface $object): void
    {
        if ($object->id === null) {
            return;
        }
        $uri = $this->getObjectUri($object->id);
        $this->client->delete($uri);
        $this->removeFromCache($object);
    }

    /**
     * Saves the object passed to it.
     *
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     *
     * @internal
     */
    public function save(AbstractModelInterface $object): void
    {
        if ($object->id !== null) {
            $this->client->put($this->getObjectUri($object->id), $object->transformForApi());
        } else {
            $response = $this->client->post($this->getBaseUri(), $object->transformForApi());
            $data = json_decode((string) $response->getBody());
            $object->populateFromApi($data);
        }
    }

    /**
     * Fetch the object from the local cache.
     *
     * @internal
     */
    public function getFromCache(string $key): ?AbstractModelInterface
    {
        if (array_key_exists($key, $this->objectCache)) {
            $this->client->logger->debug("[DnsMadeEasy] Object Cache: Fetching {$key}");
            return $this->objectCache[$key];
        }
        return null;
    }

    /**
     * Put the object into the local cache.
     *
     * @internal
     */
    public function putInCache(string $key, AbstractModelInterface $object): void
    {
        $this->client->logger->debug("[DnsMadeEasy] Object Cache: Putting {$key}");
        $this->objectCache[$key] = $object;
    }

    /**
     * Remove the object from the local cache.
     *
     * @internal
     */
    public function removeFromCache(mixed $object): void
    {
        if (is_object($object)) {
            $index = array_search($object, $this->objectCache, true);
            if ($index !== false) {
                $this->client->logger->debug("[DnsMadeEasy] Object Cache: Removing {$index}");
                unset($this->objectCache[$index]);
            }
        } else {
            $index = (string) $object;
            $this->client->logger->debug("[DnsMadeEasy] Object Cache: Removing {$index}");
            unset($this->objectCache[$index]);
        }
    }

    /**
     * Updates the object to the latest version in the API.
     *
     * @throws ModelNotFoundException
     *
     * @internal
     */
    public function refresh(AbstractModelInterface $object): void
    {
        if ($object->id === null) {
            return;
        }

        $data = $this->getFromApi($object->id);
        $object->populateFromApi($data);
    }

    /**
     * Fetches an object from the cache, or if not found, from the API.
     *
     * @throws ModelNotFoundException
     * @throws HttpException
     * @throws ReflectionException
     */
    protected function getObject(int $id): AbstractModelInterface
    {
        $objectId = $this->getObjectId($id);
        if ($this->getFromCache($objectId) !== null) {
            return $this->getFromCache($objectId);
        }

        $data = $this->getFromApi($id);
        return $this->createExistingObject($data, $this->getModelClass());
    }

    /**
     * Get the object from the API.
     *
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
        $data = json_decode((string) $response->getBody());
        return $this->transformApiData($data);
    }

    /**
     * Create a new object.
     */
    protected function createObject(?string $className = null): mixed
    {
        if ($className === null) {
            $className = $this->getModelClass();
        }
        return new $className($this, $this->client);
    }

    /**
     * Fetches the base URI for the resource.
     */
    protected function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * Fetches the URI for a resource with the specified ID.
     */
    protected function getObjectUri(int $id): string
    {
        return "{$this->getBaseUri()}/{$id}";
    }

    /**
     * Return the name of the model class for this resource.
     *
     * @throws ReflectionException
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return $this->model;
    }

    /**
     * Return the name of the model class for the concise version of the resource.
     *
     * @throws ReflectionException
     */
    protected function getConciseModelClass(): string
    {
        return $this->getModelClass();
    }

    /**
     * Returns a string ID to give a unique ID to this resource.
     *
     * @param class-string|null $name
     *
     * @throws ReflectionException
     */
    protected function getObjectId(mixed $input, string $name = null): string
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
        } elseif (is_array($input) && array_key_exists('id', $input)) {
            return "{$name}:{$input['id']}";
        }
        return "{$name}:" . (string) $input;
    }

    /**
     * Creates a new instance of an object from existing API data.
     *
     * @throws ReflectionException
     * @throws ModelNotFoundException
     */
    protected function createExistingObject(object $data, string $className): AbstractModelInterface
    {
        if (! class_exists($className)) {
            throw new ModelNotFoundException("Class {$className} not found.");
        }
        $objectId = $this->getObjectId($data, $className);

        if ($this->getFromCache($objectId) !== null) {
            return $this->getFromCache($objectId);
        }

        $object = $this->createObject($className);
        $object->populateFromApi($data);

        $this->putInCache($objectId, $object);

        return $object;
    }

    /**
     * Applies transformations to the API data before it is used to instantiate a model.
     */
    protected function transformApiData(object $data): object
    {
        return $data;
    }

    /**
     * Applies transformations to the concise API data before it is used to instantiate a model.
     */
    protected function transformConciseApiData(object $data): object
    {
        return $this->transformApiData($data);
    }
}
