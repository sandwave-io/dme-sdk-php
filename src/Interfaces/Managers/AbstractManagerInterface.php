<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Pagination\Paginator;

/**
 * Defines the interface of a Manager for a particular resource in the DNS Made Easy API.
 *
 * The manager is the way that resources are fetched, queried and updated in the SDK. There should be one for every
 * resource that can be manipulated.
 *
 * @package DnsMadeEasy
 */
interface AbstractManagerInterface
{
    /**
     * Fetch a paginated subset of the resources. You can specify the page and the number of items per-page. The result
     * will be an object representing the paginated results. By specifying a custom Paginator Factory on the client
     * you can change the type of result you get from this method.
     *
     * By default this is a Paginator with a similar interface to the LengthAwarePaginator that is provided with
     * Laravel.
     *
     * @param int $page
     * @param int $perPage
     * @return Paginator|mixed
     * @throws HttpException
     */
    public function paginate(int $page = 1, int $perPage = 20);

    /**
     * Returns a new instance of the resource.
     * @return AbstractModelInterface
     */
    public function createObject(): AbstractModelInterface;

    /**
     * Returns the resource with the specified ID. If the resource is not found then a ModelNotFoundException is thrown.
     * @param int $id
     * @return AbstractModelInterface
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): AbstractModelInterface;

    /**
     * Updates the API with changes made to the specified object. If the object is new, it will be created.
     * @param AbstractModelInterface $object
     * @throws HttpException
     */
    public function save(AbstractModelInterface $object): void;

    /**
     * Uses the API to delete the specified object. If the object is new, then no action is taken on the API.
     * @param AbstractModelInterface $object
     * @throws HttpException
     */
    public function delete(AbstractModelInterface $object): void;
}