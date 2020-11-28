<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\ModelNotFoundException;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;

/**
 * Manages Template resources from the API.
 * @package DnsMadeEasy
 */
interface TemplateManagerInterface extends AbstractManagerInterface
{
    /**
     * Creates a new Template resource.
     * @return TemplateInterface
     */
    public function createObject(): TemplateInterface;

    /**
     * Fetches the template resource with the specified ID.
     * @param int $id
     * @return TemplateInterface
     * @throws ModelNotFoundException
     * @throws HttpException
     */
    public function get(int $id): TemplateInterface;

    /**
     * Creates a new Template based on the specified domain. This is created immediately on the API and save() does not
     * need to be called on the created resource.
     * @param ManagedDomainInterface $domain
     * @param string $name
     * @return TemplateInterface
     * @throws HttpException
     */
    public function createFromDomain(ManagedDomainInterface $domain, string $name): TemplateInterface;

    /**
     * Creates a new Template based on the specified domain ID. This is created immediately on the API and save() does
     * not need to be called on the created resource.
     * @param int $domainId
     * @param string $name
     * @return TemplateInterface
     * @throws HttpException
     */
    public function createFromDomainId(int $domainId, string $name): TemplateInterface;
}