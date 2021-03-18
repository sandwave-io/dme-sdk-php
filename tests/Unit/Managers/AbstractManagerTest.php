<?php declare(strict_types = 1);

namespace DnsMadeEasy\Tests\Unit\Managers;

use DnsMadeEasy\Client;
use DnsMadeEasy\Models\Folder;
use DnsMadeEasy\Tests\Unit\Managers\Stubs\FakeManager;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class AbstractManagerTest extends TestCase
{
    public function testGetModelClass(): void
    {
        $manager = new FakeManager(new Client());

        Assert::assertSame(Folder::class, $manager->getModelClass());
    }
}
