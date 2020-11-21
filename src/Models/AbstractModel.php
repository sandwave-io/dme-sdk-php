<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use JsonSerializable;

abstract class AbstractModel implements AbstractModelInterface, JsonSerializable
{
    protected AbstractManagerInterface $manager;
    protected ?int $id = null;
    protected array $changed = [];
    protected array $props = [];
    protected array $originalProps = [];

    public function save(): void
    {
        if ($this->getId() && !$this->hasChanged()) {
            return;
        }
        $this->manager->save($this);
        $this->originalProps = $this->props;
        $this->changed = [];
    }

    public function delete(): void
    {
        if (!$this->getId()) {
            return;
        }
        $this->manager->delete($this);
    }

    public function __construct(AbstractManagerInterface $manager, ?object $data = null)
    {
        $this->manager = $manager;
        $this->originalProps = $this->props;
        if ($data) {
            $this->populateFromApi($data);
        }
    }

    public function hasChanged(): bool
    {
        return (bool) $this->changed;
    }

    public function populateFromApi(object $data): void
    {
        $this->changed = [];
        $this->id = $data->id;
    }

    public function transformForApi(): object
    {
        $obj = $this->jsonSerialize();
        if ($this->getId() === null) {
            unset($obj->id);
        }
        return $obj;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return (object) ([
            'id' => $this->getId(),
        ] + $this->props);
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->props)) {
            return $this->props[$name];
        }
        if ($name === 'id') {
            return $this->id;
        }
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->props)) {
            $this->props[$name] = $value;
            $this->changed[] = $name;
        }
    }
}