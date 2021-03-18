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
use Psr\Http\Client\ClientInterface as HttpClientInterface;
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
     *
     * @param HttpClientInterface $client
     *
     * @return ClientInterface
     */
    public function setHttpClient(HttpClientInterface $client): ClientInterface;

    /**
     * Fetches the current HTTP Client used for requests.
     *
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface;

    /**
     * Set the API endpoint to use. By default this is `https://api.dnsmadeeasy.com/V2.0`. You can set this to
     * `https://api.sandbox.dnsmadeeasy.com/V2.0` to use the Sandbox API.
     *
     * @param string $endpoint
     *
     * @return ClientInterface
     */
    public function setEndpoint(string $endpoint): ClientInterface;

    /**
     * Fetch the current API endpoint.
     *
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * Sets the API key used for requests.
     *
     * @param string $key
     *
     * @return ClientInterface
     */
    public function setApiKey(string $key): ClientInterface;

    /**
     * Fetch the current API key.
     *
     * @return string
     */
    public function getApiKey(): string;

    /**
     * Sets the secret key for requests.
     *
     * @param string $key
     *
     * @return ClientInterface
     */
    public function setSecretKey(string $key): ClientInterface;

    /**
     * Fetch the current secret key.
     *
     * @return string
     */
    public function getSecretKey(): string;

    /**
     * This sets a Paginator Factory for the client. Any paginated responses will be created using the factory
     * specified. This is useful if you have a custom pagination class you want to use or one provided by a framework
     * such as the LengthAwarePaginator in Laravel.
     *
     * The default paginator used supports all the usual methods and properties you'd expect from a pagination class
     * and is iterable.
     *
     * @param PaginatorFactoryInterface $factory
     *
     * @return ClientInterface
     */
    public function setPaginatorFactory(PaginatorFactoryInterface $factory): ClientInterface;

    /**
     * Fetch the current paginator factory interface.
     *
     * @return PaginatorFactoryInterface
     */
    public function getPaginatorFactory(): PaginatorFactoryInterface;

    /**
     * Make a GET request to the API. The parameters will be encoded as query string parameters.
     *
     * @param string $url
     * @param array  $params
     *
     * @throws HttpException
     *
     * @return ResponseInterface
     */
    public function get(string $url, array $params = []): ResponseInterface;

    /**
     * Make a POST request to the API. The payload will be JSON encoded and sent in the body of the request with
     * `Content-Type: application/json` headers.
     *
     * @param string $url
     * @param $payload
     *
     * @throws HttpException
     *
     * @return ResponseInterface
     */
    public function post(string $url, $payload): ResponseInterface;

    /**
     * Make a PUT request to the API. The payload will be JSON encoded and sent in the body of the request with
     * `Content-Type: application/json` headers.
     *
     * @param string $url
     * @param $payload
     *
     * @throws HttpException
     *
     * @return ResponseInterface
     */
    public function put(string $url, $payload): ResponseInterface;

    /**
     * Make a DELETE request to the API.
     *
     * @param string     $url
     * @param mixed|null $payload
     *
     * @throws HttpException
     *
     * @return ResponseInterface
     */
    public function delete(string $url, $payload = null): ResponseInterface;

    /**
     * Makes a HTTP request to the API.
     *
     * @param RequestInterface $request
     *
     * @throws HttpException
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request): ResponseInterface;

    /**
     * Return the ID of the last API request.
     *
     * @return string|null
     */
    public function getLastRequestId(): ?string;

    /**
     * Get the request limit.
     *
     * @return int|null
     */
    public function getRequestLimit(): ?int;

    /**
     * Get the number of requests remaining before you hit the request limit.
     *
     * @return int|null
     */
    public function getRequestsRemaining(): ?int;
}
