<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Models\Common;

use DnsMadeEasy\Interfaces\Models\Common\CommonSecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Models\AbstractModel;

/**
 * Abstract model representing common properties and functionality between secondary domain model implementions.
 *
 * @package DnsMadeEasy\Models
 *
 * @property int|null $folderId
 */
abstract class CommonSecondaryDomain extends AbstractModel implements CommonSecondaryDomainInterface
{
    /**
     * Parses the API data.
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
     * Fetches the folder that the secondary domain is using.
     */
    protected function getFolder(): ?FolderInterface
    {
        if ($this->folderId === null) {
            return null;
        }
        return $this->client->folders->get($this->folderId);
    }
}
