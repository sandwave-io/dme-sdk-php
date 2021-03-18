<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces\Managers;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\TemplateRecordInterface;

/**
 * Manages Template Record resources from the API.
 *
 * @package DnsMadeEasy\Interfaces
 */
interface TemplateRecordManagerInterface extends AbstractManagerInterface
{
    /**
     * Sets the template used for the manager.
     *
     * @param TemplateInterface $template
     *
     * @return $this
     */
    public function setTemplate(TemplateInterface $template): self;

    /**
     * Creates a new Template Record resource.
     *
     * @return TemplateRecordInterface
     */
    public function create(): TemplateRecordInterface;

    /**
     * Returns the Template Record resource with the specified ID.
     *
     * @param int $id
     *
     * @throws HttpException
     *
     * @return TemplateRecordInterface
     */
    public function get(int $id): TemplateRecordInterface;
}
