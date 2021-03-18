<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Traits;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Pagination\Paginator;

trait ListableManager
{
    /**
     * Fetch a paginated subset of the resources. You can specify the page and the number of items per-page. The result
     * will be an object representing the paginated results. By specifying a custom Paginator Factory on the client
     * you can change the type of result you get from this method.
     *
     * By default this is a Paginator with a similar interface to the LengthAwarePaginator that is provided with
     * Laravel.
     *
     * @param int        $page
     * @param int        $perPage
     * @param array|null $filters
     *
     * @throws HttpException
     *
     * @return Paginator|mixed
     */
    public function paginate(int $page = 1, int $perPage = 20, $filters = [])
    {
        $params = $filters + [
                'page' => $page,
                'rows' => $perPage,
            ];
        $response = $this->client->get($this->getBaseUri(), $params);
        $data = json_decode((string) $response->getBody());
        $items = array_map(
            function ($data) {
                $data = $this->transformConciseApiData($data);
                return $this->createExistingObject($data, $this->getConciseModelClass());
            },
            $data->data
        );

        return $this->client->getPaginatorFactory()->paginate($items, $data->totalRecords, $perPage, $page);
    }
}
