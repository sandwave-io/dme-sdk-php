<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Interfaces\Models\FolderInterface;

interface FolderManagerInterface extends AbstractManagerInterface
{
    public function createObject(): FolderInterface;
    public function get(int $id): FolderInterface;
}