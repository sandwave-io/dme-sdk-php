<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit\Managers\Stubs;

use DnsMadeEasy\Managers\AbstractManager;
use DnsMadeEasy\Models\Folder;

class FakeManager extends AbstractManager
{
    protected string $model = Folder::class;

    public function getModelClass(): string
    {
        return parent::getModelClass();
    }
}
