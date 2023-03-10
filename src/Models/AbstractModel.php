<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use JsonSerializable;

/**
 * An abstract class for resource models in the Dns Made Easy API.
 *
 * @package DnsMadeEasy\Models
 *
 * @property-read int $id
 */
abstract class AbstractModel implements AbstractModelInterface, JsonSerializable
{
    /**
     * The manager for this object.
     */
    protected AbstractManagerInterface $manager;

    /**
     * The Dns Made Easy API Client.
     */
    protected ClientInterface $client;

    /**
     * The ID of the object.
     */
    protected ?int $id = null;

    /**
     * A list of properties that have been modified since the object was last saved.
     *
     * @var string[]
     */
    protected array $changed = [];

    /**
     * The properties of this object.
     *
     * @var mixed[]
     */
    protected array $props = [];

    /**
     * The original properties from when the object was instantiated/last loaded from the API.
     *
     * @var string[]
     */
    protected array $originalProps = [];

    /**
     * A list of properties that are editable on this model.
     *
     * @var string[]
     */
    protected array $editable = [];

    /**
     * The original data retrieved from the API.
     */
    protected ?object $apiData = null;

    /**
     * Creates the model and optionally populates it with data.
     *
     * @internal
     */
    public function __construct(AbstractManagerInterface $manager, ClientInterface $client, ?object $data = null)
    {
        $this->manager = $manager;
        $this->client = $client;
        $this->originalProps = $this->props;
        if ($data !== null) {
            $this->populateFromApi($data);
        }
    }

    /**
     * Returns a string representation of the model's class and ID.
     *
     * @throws \ReflectionException
     *
     * @internal
     */
    public function __toString(): string
    {
        $rClass = new \ReflectionClass($this);
        $modelName = $rClass->getShortName();
        if ($this->id === null) {
            return "{$modelName}:#";
        }
        return "{$modelName}:{$this->id}";
    }

    /**
     * Magic method to fetch properties for the object. If a get{Name} method exists, it will be called  first,
     * otherwise it will try and fetch it from the properties array.
     *
     * @internal
     */
    public function __get(string $name): mixed
    {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        } elseif (array_key_exists($name, $this->props)) {
            return $this->props[$name];
        }
        return null;
    }

    /**
     * Magic method for setting properties for the object. If a method called set{Name} exists, then it will be called,
     * otherwise if the property is in the props array and is editable, it will be updated.
     *
     * Changes are tracked to allow us to see any changes.
     *
     * @throws ReadOnlyPropertyException
     *
     * @internal
     */
    public function __set(string $name, mixed $value): void
    {
        $methodName = 'set' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            $this->{$methodName}($value);
        } elseif (in_array($name, $this->editable, true)) {
            $this->props[$name] = $value;
            $this->changed[] = $name;
        } elseif (array_key_exists($name, $this->props)) {
            throw new ReadOnlyPropertyException("Unable to set {$name}");
        }
    }

    public function save(): void
    {
        if ($this->id !== null && ! $this->hasChanged()) {
            return;
        }
        $this->manager->save($this);
        $this->originalProps = $this->props;
        $this->changed = [];
    }

    public function delete(): void
    {
        if ($this->id === null) {
            return;
        }
        $this->manager->delete($this);
    }

    public function hasChanged(): bool
    {
        return (bool) $this->changed;
    }

    /**
     * @internal
     */
    public function populateFromApi(object $data): void
    {
        $this->apiData = $data;
        $this->id = $data->id;
        $this->parseApiData($data);
        $this->originalProps = $this->props;
        $this->changed = [];
    }

    /**
     * Generate a representation of the object for sending to the API.
     *
     * @internal
     */
    public function transformForApi(): object
    {
        $obj = $this->jsonSerialize();
        if ($this->id === null) {
            unset($obj->{$this->id});
        }
        // These don't exist
        foreach ($obj as $key => $value) {
            if ($value === null || (is_array($value) && ! $value)) {
                unset($obj->$key);
            }
        }
        return $obj;
    }

    /**
     * Returns a JSON serializable representation of the resource.
     *
     * @internal
     */
    public function jsonSerialize(): mixed
    {
        $result = (object) [
            'id' => $this->id,
        ];
        foreach ($this->props as $name => $value) {
            if ($value instanceof \DateTime) {
                $value = $value->format('c');
            }
            $result->{$name} = $value;
        }
        return $result;
    }

    public function refresh(): void
    {
        $this->manager->refresh($this);
    }

    /**
     * Parses the API data and assigns it to properties on this object.
     */
    protected function parseApiData(object $data): void
    {
        foreach ($data as $prop => $value) {
            try {
                $this->{$prop} = $value;
            } catch (ReadOnlyPropertyException $ex) {
                $this->props[$prop] = $value;
            }
        }
    }

    /**
     * Returns the ID of the object. Since ID is a protected property, this is required for fetching it.
     */
    protected function getId(): ?int
    {
        return $this->id;
    }
}
