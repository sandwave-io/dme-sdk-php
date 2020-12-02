<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Traits;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Pagination\Paginator;

/**
 * Fnctionality for paginated indexed resources.
 * @package DnsMadeEasy\Interfaces
 */
interface ListableManagerInterface
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
     * @param array|null $filters
     * @return Paginator|mixed
     * @throws HttpException
     */
    public function paginate(int $page = 1, int $perPage = 20, $filters = []);
}