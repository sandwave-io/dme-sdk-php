<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\FolderManagerInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Models\Concise\ConciseFolder;
use DnsMadeEasy\Models\Folder;

/**
 * Manager for Folder resources.
 *
 * @package DnsMadeEasy\Managers
 */
class FolderManager extends AbstractManager implements FolderManagerInterface, ListableManagerInterface
{
    /**
     * Base URI for Folder resources.
     *
     * @var string
     */
    protected string $baseUri = '/security/folder';

    protected string $model = Folder::class;

    /**
     * Paginates folder resources.
     *
     * {@internal This is different to the other resources in that the API endpoint does not appear to
     * be paginated. Instead for consistency, we'll simulate pagination.}
     *
     * @param int        $page
     * @param int        $perPage
     * @param array|null $filters
     *
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     * @throws \ReflectionException
     *
     * @return \DnsMadeEasy\Pagination\Paginator|mixed
     */
    public function paginate(int $page = 1, int $perPage = 20, $filters = [])
    {
        $response = $this->client->get($this->getBaseUri());
        $data = json_decode((string) $response->getBody());
        $dataSet = array_slice($data, ($page - 1) * $perPage, $perPage);
        $items = array_map(
            function ($data) {
                $data = $this->transformConciseApiData($data);
                return $this->createExistingObject($data, $this->getConciseModelClass());
            },
            $dataSet
        );

        return $this->client->getPaginatorFactory()->paginate($items, count($data), $perPage, $page);
    }

    public function get(int $id): FolderInterface
    {
        return $this->getObject($id);
    }

    public function create(): FolderInterface
    {
        return $this->createObject();
    }

    /**
     * Returns the model class for Concise Folder resources.
     *
     * @return string
     */
    protected function getConciseModelClass(): string
    {
        return ConciseFolder::class;
    }

    /**
     * Applies transformations to the concise data for a Folder.
     *
     * @param object $data
     *
     * @return object
     */
    protected function transformConciseApiData(object $data): object
    {
        return (object) [
            'id' => $data->value,
            'label' => $data->label,
        ];
    }
}
