<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models\Concise;

use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;

interface ConciseFolderInterface extends AbstractModelInterface
{
    public function getFull(): FolderInterface;
}