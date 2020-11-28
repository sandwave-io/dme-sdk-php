<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Common;

use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Models\AbstractModel;

/**
 * @package DnsMadeEasy
 */
abstract class CommonManagedDomain extends AbstractModel implements CommonManagedDomainInterface
{
    protected function parseApiData(object $data): void
    {
        parent::parseApiData($data);
        $this->props['updated'] = new \DateTime('@' . floor($data->updated / 1000));
        $this->props['created'] = new \DateTime('@' . floor($data->created / 1000));
    }

    protected function getTemplate(): ?TemplateInterface
    {
        if (!$this->templateId) {
            return;
        }

        return $this->client->templates->get($this->templateId);
    }

    protected function getFolder(): ?FolderInterface
    {
        if (!$this->folderId) {
            return null;
        }
        return $this->client->folders->get($this->folderId);
    }

    public function getUsage(int $year, int $month): array
    {
        return $this->client->usage->getForDomain($this, $year, $month);
    }

    public function createTemplate(string $name): TemplateInterface
    {
        return $this->client->templates->createFromDomain($this, $name);
    }
}