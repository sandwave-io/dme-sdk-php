<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Interfaces;

use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Interfaces\Managers\ContactListManagerInterface;
use DnsMadeEasy\Interfaces\Managers\FolderManagerInterface;
use DnsMadeEasy\Interfaces\Managers\ManagedDomainManagerInterface;
use DnsMadeEasy\Interfaces\Managers\RecordFailoverManagerInterface;
use DnsMadeEasy\Interfaces\Managers\SecondaryDomainManagerInterface;
use DnsMadeEasy\Interfaces\Managers\SecondaryIPSetManagerInterface;
use DnsMadeEasy\Interfaces\Managers\SOARecordManagerInterface;
use DnsMadeEasy\Interfaces\Managers\TemplateManagerInterface;
use DnsMadeEasy\Interfaces\Managers\TransferAclManagerInterface;
use DnsMadeEasy\Interfaces\Managers\UsageManagerInterface;
use DnsMadeEasy\Interfaces\Managers\VanityNameServerManagerInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * DnsMadeEasy API Client SDK.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property-read ContactListManagerInterface $contactlists
 * @property-read FolderManagerInterface $folders
 * @property-read ManagedDomainManagerInterface $domains
 * @property-read VanityNameServerManagerInterface $vanity
 * @property-read TemplateManagerInterface $templates
 * @property-read TransferAclManagerInterface $transferacls
 * @property-read SOARecordManagerInterface $soarecords
 * @property-read UsageManagerInterface $usage
 * @property-read SecondaryIPSetManagerInterface $secondaryipsets;
 * @property-read SecondaryDomainManagerInterface $secondarydomains;
 * @property-read RecordFailoverManagerInterface $failover;
 */
interface ClientInterface
{
    /**
     * Set a custom HTTP Client for all requests. If one is not provided, one is created automatically.
     */
    public function setHttpClient(Client $client): ClientInterface;

    /**
     * Fetches the current HTTP Client used for requests.
     */
    public function getHttpClient(): Client;

    /**
     * Set the API endpoint to use. By default this is `https://api.dnsmadeeasy.com/V2.0`. You can set this to
     * `https://api.sandbox.dnsmadeeasy.com/V2.0` to use the Sandbox API.
     */
    public function setEndpoint(string $endpoint): ClientInterface;

    /**
     * Fetch the current API endpoint.
     */
    public function getEndpoint(): string;

    /**
     * Sets the API key used for requests.
     */
    public function setApiKey(string $key): ClientInterface;

    /**
     * Fetch the current API key.
     */
    public function getApiKey(): string;

    /**
     * Sets the secret key for requests.
     */
    public function setSecretKey(string $key): ClientInterface;

    /**
     * Fetch the current secret key.
     */
    public function getSecretKey(): string;

    /**
     * This sets a Paginator Factory for the client. Any paginated responses will be created using the factory
     * specified. This is useful if you have a custom pagination class you want to use or one provided by a framework
     * such as the LengthAwarePaginator in Laravel.
     *
     * The default paginator used supports all the usual methods and properties you'd expect from a pagination class
     * and is iterable.
     */
    public function setPaginatorFactory(PaginatorFactoryInterface $factory): ClientInterface;

    /**
     * Fetch the current paginator factory interface.
     */
    public function getPaginatorFactory(): PaginatorFactoryInterface;

    /**
     * Make a GET request to the API. The parameters will be encoded as query string parameters.
     *
     * @param mixed[] $params
     *
     * @throws HttpException
     */
    public function get(string $url, ?array $params = null): ResponseInterface;

    /**
     * Make a POST request to the API. The payload will be JSON encoded and sent in the body of the request with
     * `Content-Type: application/json` headers.
     *
     * @throws HttpException
     */
    public function post(string $url, mixed $payload): ResponseInterface;

    /**
     * Make a PUT request to the API. The payload will be JSON encoded and sent in the body of the request with
     * `Content-Type: application/json` headers.
     *
     * @throws HttpException
     */
    public function put(string $url, mixed $payload): ResponseInterface;

    /**
     * Make a DELETE request to the API.
     *
     * @throws HttpException
     */
    public function delete(string $url, mixed $payload = null): ResponseInterface;

    /**
     * Makes a HTTP request to the API.
     *
     * @throws HttpException
     */
    public function send(RequestInterface $request): ResponseInterface;

    /**
     * Return the ID of the last API request.
     */
    public function getLastRequestId(): ?string;

    /**
     * Get the request limit.
     */
    public function getRequestLimit(): ?int;

    /**
     * Get the number of requests remaining before you hit the request limit.
     */
    public function getRequestsRemaining(): ?int;
}
