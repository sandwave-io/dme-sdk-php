<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\FolderManagerInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Models\Concise\ConciseFolder;
use DnsMadeEasy\Models\Folder;
use DnsMadeEasy\Pagination\Paginator;

/**
 * Manager for Folder resources.
 *
 * @package DnsMadeEasy\Managers
 */
class FolderManager extends AbstractManager implements FolderManagerInterface, ListableManagerInterface
{
    /**
     * Base URI for Folder resources.
     */
    protected string $baseUri = '/security/folder';

    protected string $model = Folder::class;

    /**
     * Paginates folder resources.
     *
     * {@internal This is different to the other resources in that the API endpoint does not appear to
     * be paginated. Instead for consistency, we'll simulate pagination.}
     *
     * @param mixed[] $filters
     *
     * @throws \DnsMadeEasy\Exceptions\Client\Http\HttpException
     * @throws \ReflectionException
     */
    public function paginate(int $page = 1, int $perPage = 20, ?array $filters = []): Paginator|mixed
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
     */
    protected function getConciseModelClass(): string
    {
        return ConciseFolder::class;
    }

    /**
     * Applies transformations to the concise data for a Folder.
     */
    protected function transformConciseApiData(object $data): object
    {
        return (object) [
            'id' => $data->value,
            'label' => $data->label,
        ];
    }
}
