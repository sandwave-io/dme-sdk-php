<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\TemplateRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\TemplateRecordInterface;
use DnsMadeEasy\Models\TemplateRecord;

/**
 * Manager for Template record resources.
 *
 * @package DnsMadeEasy\Managers
 */
class TemplateRecordManager extends RecordManager implements TemplateRecordManagerInterface
{
    protected string $model = TemplateRecord::class;

    /**
     * Base URI for template record resources.
     */
    protected string $baseUri = '/dns/template/:template/records';

    /**
     * The Template for the manager.
     */
    protected ?TemplateInterface $template = null;

    public function create(): TemplateRecordInterface
    {
        return $this->createObject();
    }

    public function get(int $id): TemplateRecordInterface
    {
        return $this->getObject($id);
    }

    /**
     * Sets the template for the manager.
     *
     * @return $this|TemplateRecordManagerInterface
     *
     * @internal
     */
    public function setTemplate(TemplateInterface $template): TemplateRecordManagerInterface
    {
        $this->template = $template;
        $this->baseUri = str_replace(':template', (string) $template->id, $this->baseUri);
        return $this;
    }

    /**
     * Gets the template for the manager.
     *
     * @internal
     */
    public function getTemplate(): ?TemplateInterface
    {
        return $this->template;
    }

    /**
     * Create a new Template Record.
     */
    protected function createObject(?string $className = null): AbstractModelInterface
    {
        $record = parent::createObject($className);
        $record->setTemplate($this->template);
        return $record;
    }
}
