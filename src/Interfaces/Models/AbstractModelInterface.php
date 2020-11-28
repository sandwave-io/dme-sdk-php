<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;

/**
 * Represents a resource from the DNS Made Easy API.
 *
 * @package DnsMadeEasy
 *
 * @property-read int $id
 */
interface AbstractModelInterface
{
    /**
     * Creates a new model of the resource
     *
     * @param AbstractManagerInterface $manager
     * @param ClientInterface $client
     * @param object|null $data
     */
    public function __construct(AbstractManagerInterface $manager, ClientInterface $client, ?object $data = null);

    /**
     * Saves the object.
     */
    public function save(): void;

    /**
     * Deletes the object.
     */
    public function delete(): void;

    /**
     * Returns true if the object has been modified since it was fetched.
     *
     * @return bool
     */
    public function hasChanged(): bool;

    /**
     * Fetch the latest version of the object from the API. This will overwrite changes that have been made.
     */
    public function refresh(): void;

    /**
     * Populate the object from API data.
     *
     * @param object $data
     */
    public function populateFromApi(object $data): void;

    /**
     * Generate a representation of the object for sending to the API.
     *
     * @return object
     */
    public function transformForApi(): object;
}