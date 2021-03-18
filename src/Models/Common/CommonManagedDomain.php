<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models\Common;

use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Models\AbstractModel;

/**
 * Abstract model representing common properties and functionality between managed domain model implementations.
 *
 * @package DnsMadeEasy\Models
 */
abstract class CommonManagedDomain extends AbstractModel implements CommonManagedDomainInterface
{
    /**
     * Get query usage data for this domain.
     *
     * @param int $year
     * @param int $month
     *
     * @return array
     */
    public function getUsage(int $year, int $month): array
    {
        return $this->client->usage->getForDomain($this, $year, $month);
    }

    /**
     * Create a new template based on the records in this domain.
     *
     * @param string $name
     *
     * @return TemplateInterface
     */
    public function createTemplate(string $name): TemplateInterface
    {
        return $this->client->templates->createFromDomain($this, $name);
    }

    /**
     * Parses the API data and sets the properties on the model.
     *
     * @param object $data
     *
     * @throws \Exception
     */
    protected function parseApiData(object $data): void
    {
        parent::parseApiData($data);
        $this->props['updated'] = new \DateTime('@' . floor($data->updated / 1000));
        $this->props['created'] = new \DateTime('@' . floor($data->created / 1000));
    }

    /**
     * Get the template associated with this domain.
     *
     * @return TemplateInterface|null
     */
    protected function getTemplate(): ?TemplateInterface
    {
        if (! $this->templateId) {
            return null;
        }

        return $this->client->templates->get($this->templateId);
    }

    /**
     * Get the folder that the domain has been assigned to.
     *
     * @return FolderInterface|null
     */
    protected function getFolder(): ?FolderInterface
    {
        if (! $this->folderId) {
            return null;
        }
        return $this->client->folders->get($this->folderId);
    }
}
