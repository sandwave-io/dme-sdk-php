<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;

/**
 * Manages Secondary IP Set resources from the API.
 * @package DnsMadeEasy\Interfaces
 */
interface SecondaryIPSetManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Secondary IP Set resource.
     * @return SecondaryIPSetInterface
     */
    public function create(): SecondaryIPSetInterface;

    /**
     * Gets the Secondary IP Set resource with the specified ID.
     * @param int $id
     * @return SecondaryIPSetInterface
     * @throws HttpException
     */
    public function get(int $id): SecondaryIPSetInterface;
}