<?php
declare(strict_types=1);

namespace DnsMadeEasy\Models\Common;

use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonSecondaryDomainInterface;
use DnsMadeEasy\Interfaces\Models\FolderInterface;
use DnsMadeEasy\Interfaces\Models\SecondaryIPSetInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Models\AbstractModel;

/**
 * @package DnsMadeEasy\Models
 */
abstract class CommonSecondaryDomain extends AbstractModel implements CommonSecondaryDomainInterface
{
    protected function parseApiData(object $data): void
    {
        parent::parseApiData($data);
        $this->props['updated'] = new \DateTime('@' . floor($data->updated / 1000));
        $this->props['created'] = new \DateTime('@' . floor($data->created / 1000));
    }

    protected function getFolder(): ?FolderInterface
    {
        if (!$this->folderId) {
            return null;
        }
        return $this->client->folders->get($this->folderId);
    }
}