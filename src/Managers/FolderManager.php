<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\FolderManagerInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Models\ConciseFolder;

class FolderManager extends AbstractManager implements FolderManagerInterface
{
    protected string $baseUri = '/security/folder';

    public function paginate(int $page = 1, int $perPage = 20)
    {
        $response = $this->client->get($this->getBaseUri());
        $data = json_decode((string) $response->getBody());
        $dataSet = array_slice($data, ($page - 1) * $perPage, $perPage);
        $items = array_map(function ($data) {
            $data = $this->transformConciseApiData($data);
            return $this->createExistingObject($data, $this->getConciseModelClass());;
        }, $dataSet);

        return $this->client->getPaginatorFactory()->paginate($items, count($data), $perPage, $page);
    }

    public function getConciseModelClass(): string
    {
        return \DnsMadeEasy\Models\Concise\ConciseFolder::class;
    }

    public function get(int $id): FolderInterface
    {
        return parent::get($id);
    }

    protected function transformConciseApiData(object $data): object
    {
        return (object) [
            'id' => $data->value,
            'label' => $data->label,
        ];
    }
}