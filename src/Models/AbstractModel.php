<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use JsonSerializable;

/**
 * @internal
 * @package DnsMadeEasy\Models
 *
 * @property-read int $id
 */
abstract class AbstractModel implements AbstractModelInterface, JsonSerializable
{
    protected AbstractManagerInterface $manager;
    protected ClientInterface $client;
    protected ?int $id = null;
    protected array $changed = [];
    protected array $props = [];
    protected array $originalProps = [];
    protected array $editable = [];
    protected ?object $apiData = null;

    public function save(): void
    {
        if ($this->id && !$this->hasChanged()) {
            return;
        }
        $this->manager->save($this);
        $this->originalProps = $this->props;
        $this->changed = [];
    }

    public function delete(): void
    {
        if (!$this->id) {
            return;
        }
        $this->manager->delete($this);
    }

    /**
     * AbstractModel constructor.
     * @internal
     * @param AbstractManagerInterface $manager
     * @param ClientInterface $client
     * @param object|null $data
     */
    public function __construct(AbstractManagerInterface $manager, ClientInterface $client, ?object $data = null)
    {
        $this->manager = $manager;
        $this->client = $client;
        $this->originalProps = $this->props;
        if ($data) {
            $this->populateFromApi($data);
        }
    }

    /**
     * @internal
     * @return string
     * @throws \ReflectionException
     */
    public function __toString()
    {
        $rClass = new \ReflectionClass($this);
        $modelName = $rClass->getShortName();
        if ($this->id === null) {
            return "{$modelName}:#";
        }
        return "{$modelName}:{$this->id}";
    }

    public function hasChanged(): bool
    {
        return (bool) $this->changed;
    }

    /**
     * @internal
     * @param object $data
     */
    public function populateFromApi(object $data): void
    {
        $this->apiData = $data;
        $this->id = $data->id;
        $this->parseApiData($data);
        $this->originalProps = $this->props;
        $this->changed = [];
    }

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
     * @internal
     * @return object
     */
    public function transformForApi(): object
    {
        $obj = $this->jsonSerialize();
        if ($this->id === null) {
            unset($obj->{$this->id});
        }
        // These don't exist
        foreach ($obj as $key => $value) {
            if ($value === null || (is_array($value) && !$value)) {
                unset($obj->$key);
            }
        }
        return $obj;
    }

    /**
     * @internal
     * @return mixed|object
     */
    public function jsonSerialize()
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

    protected function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @internal
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        } elseif (array_key_exists($name, $this->props)) {
            return $this->props[$name];
        }
    }

    /**
     * @internal
     * @param $name
     * @param $value
     * @throws ReadOnlyPropertyException
     */
    public function __set($name, $value)
    {
        $methodName = 'set' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            $this->{$methodName}($value);
        } elseif (in_array($name, $this->editable)) {
            $this->props[$name] = $value;
            $this->changed[] = $name;
        } elseif (array_key_exists($name, $this->props)) {
            throw new ReadOnlyPropertyException("Unable to set {$name}");
        }
    }
}