<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\TemplateRecordManagerInterface;
use DnsMadeEasy\Interfaces\Models\AbstractModelInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Models\TemplateRecordInterface;

/**
 * @package DnsMadeEasy\Managers
 */
class TemplateRecordManager extends AbstractManager implements TemplateRecordManagerInterface
{
    protected string $baseUri = '/dns/template/:template/records';
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
     * @internal
     * @param TemplateInterface $template
     * @return $this|TemplateRecordManagerInterface
     */
    public function setDomain(TemplateInterface $template): TemplateRecordManagerInterface
    {
        $this->template = $template;
        $this->baseUri = str_replace(':template', $template->id, $this->baseUri);
        return $this;
    }

    /**
     * @internal
     * @return TemplateInterface|null
     */
    public function getTemplate(): ?TemplateInterface
    {
        return $this->template;
    }

    protected function createObject(?string $className = null): AbstractModelInterface
    {
        $record = parent::createObject($className);
        $record->setTemplate($this->template);
        return $record;
    }
}