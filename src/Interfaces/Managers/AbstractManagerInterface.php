<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;

interface AbstractManagerInterface
{
    public function paginate(int $page = 1, int $perPage = 20);
    public function createObject(): AbstractModelInterface;
    public function get(int $id): ?AbstractModelInterface;
    public function save(AbstractModelInterface $object): void;
    public function delete(AbstractModelInterface $object): void;
}