<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\FolderInterface;

/**
 * Manages Folder objects from the API.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface FolderManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Folder resource.
     */
    public function create(): FolderInterface;

    /**
     * Gets the Folder resource with the specified ID.
     *
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): FolderInterface;
}
