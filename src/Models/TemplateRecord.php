<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models;

use DnsMadeEasy\Enums\RecordType;
use DnsMadeEasy\Exceptions\Client\ReadOnlyPropertyException;
use DnsMadeEasy\Interfaces\Models\DomainRecordInterface;
use DnsMadeEasy\Interfaces\Models\ManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\TemplateRecordInterface;

/**
 * @package DnsMadeEasy\Models
 *
 * @property TemplateInterface $template
 * @property int $templateId
 */
class TemplateRecord extends Record implements TemplateRecordInterface
{
    protected ?TemplateInterface $template = null;

    /**
     * @internal
     * @param TemplateInterface $template
     * @return $this
     * @throws ReadOnlyPropertyException
     */
    public function setTemplate(TemplateInterface $template): self
    {
        if ($this->template) {
            throw new ReadOnlyPropertyException('Template can only be set once');
        }
        $this->template = $template;
        return $this;
    }

    protected function getTemplate(): ?TemplateRecordInterface
    {
        return $this->domain;
    }

    protected function getTemplateId(): ?int
    {
        if (!$this->template) {
            return null;
        }
        return $this->template->id;
    }
}