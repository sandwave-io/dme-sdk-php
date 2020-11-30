<?php

declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\TemplateRecordInterface;

/**
 * Represents a Template Record resource.
 * @package DnsMadeEasy\Models
 *
 * @property TemplateInterface $template
 * @property int $templateId
 */
class TemplateRecord extends Record implements TemplateRecordInterface
{
    protected ?TemplateInterface $template = null;

    /**
     * Sets the template for the record.
     * @param TemplateInterface $template
     * @return $this
     * @throws ReadOnlyPropertyException
     * @internal
     */
    public function setTemplate(TemplateInterface $template): self
    {
        if ($this->template) {
            throw new ReadOnlyPropertyException('Template can only be set once');
        }
        $this->template = $template;
        return $this;
    }

    /**
     * Gets the template for the record.
     * @return TemplateRecordInterface|null
     */
    protected function getTemplate(): ?TemplateRecordInterface
    {
        return $this->domain;
    }

    /**
     * Gets the template ID for the record.
     * @return int|null
     */
    protected function getTemplateId(): ?int
    {
        if (!$this->template) {
            return null;
        }
        return $this->template->id;
    }
}