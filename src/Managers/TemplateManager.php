<?php
declare(strict_types=1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\TemplateManagerInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;

/**
 * @package DnsMadeEasy
 */
class TemplateManager extends AbstractManager implements TemplateManagerInterface
{
    protected string $baseUri = '/dns/template';

    public function createObject(): TemplateInterface
    {
        return parent::createObject();
    }

    public function get(int $id): TemplateInterface
    {
        return parent::get($id);
    }

    public function createFromDomain(CommonManagedDomainInterface $domain, string $name): TemplateInterface
    {
        return $this->createFromDomainId($domain->id, $name);
    }

    public function createFromDomainId(int $domainId, string $name): TemplateInterface
    {
        $payload = (object) [
            'name' => $name,
            'fromDomainId' => $domainId,
        ];
        $response = $this->client->post($this->baseUri, $payload);
        $data = json_decode((string) $response->getBody());

        $object = $this->createObject();
        $object->populateFromApi($data);
        return $object;
    }
}