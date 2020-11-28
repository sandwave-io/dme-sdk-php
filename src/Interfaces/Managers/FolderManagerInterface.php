<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\FolderInterface;

/**
 * Manages Folder objects from the API.
 * @package DnsMadeEasy
 */
interface FolderManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Folder resource.
     * @return FolderInterface
     */
    public function createObject(): FolderInterface;

    /**
     * Gets the Folder resource with the specified ID.
     * @param int $id
     * @return FolderInterface
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): FolderInterface;
}