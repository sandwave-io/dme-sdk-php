<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;

interface AbstractModelInterface
{
    public function __construct(AbstractManagerInterface $manager, ClientInterface $client, ?object $data = null);
    public function save(): void;
    public function delete(): void;
    public function hasChanged(): bool;
    public function populateFromApi(object $data): void;
    public function transformForApi(): object;
}