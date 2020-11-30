<?php

declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Managers\RecordFailoverManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\RecordFailoverInterface;

/**
 * Manager for Record Failover configuration.
 * @package DnsMadeEasy\Managers
 */
class RecordFailoverManager extends AbstractManager implements RecordFailoverManagerInterface
{
    /**
     * Base URI for failover configuration.
     * @var string
     */
    protected string $baseUri = '/monitor';

    public function get(int $recordId): RecordFailoverInterface
    {
        try {
            return $this->getObject($recordId);
        } catch (ModelNotFoundException $e) {
            $model = $this->createObject($this->getModelClass());
            $model->populateFromApi(
                (object)[
                    'id' => $recordId,
                ]
            );
            return $model;
        }
    }

    /**
     * Updates the API with changes made to the specified object. If the object is new, it will be created.
     * @param RecordFailoverInterface $object
     * @throws HttpException
     * @internal
     */
    public function save(AbstractModelInterface $object): void
    {
        $this->client->put($this->getObjectUri($object->id), $object->transformForApi());
    }

    /**
     * Applies transformations to the API data before it is used to instantiate a model.
     * @param object $data
     * @return object
     */
    protected function transformApiData(object $data): object
    {
        $data->id = $data->recordId;
        return $data;
    }
}