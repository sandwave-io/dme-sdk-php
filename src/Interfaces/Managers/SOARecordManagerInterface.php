<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\SOARecordInterface;

/**
 * Manages SOA Record resources from the API.
 * @package DnsMadeEasy\Interfaces
 */
interface SOARecordManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new SOA Record resource.
     * @return SOARecordInterface
     */
    public function create(): SOARecordInterface;

    /**
     * Returns the SOA Record resource with the specified ID.
     * @param int $id
     * @return SOARecordInterface
     * @throws HttpException
     */
    public function get(int $id): SOARecordInterface;
}