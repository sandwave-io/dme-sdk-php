<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Managers;

use DnsMadeEasy\Interfaces\Managers\TemplateManagerInterface;
use DnsMadeEasy\Interfaces\Models\Common\CommonManagedDomainInterface;
use DnsMadeEasy\Interfaces\Models\TemplateInterface;
use DnsMadeEasy\Interfaces\Traits\ListableManagerInterface;
use DnsMadeEasy\Models\Template;
use DnsMadeEasy\Traits\ListableManager;

/**
 * Manager for Template resources.
 *
 * @package DnsMadeEasy\Managers
 */
class TemplateManager extends AbstractManager implements TemplateManagerInterface, ListableManagerInterface
{
    use ListableManager;

    protected string $model = Template::class;

    /**
     * Base URI for template resources.
     */
    protected string $baseUri = '/dns/template';

    public function create(): TemplateInterface
    {
        return $this->createObject();
    }

    public function get(int $id): TemplateInterface
    {
        return $this->getObject($id);
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
