<?php

declare(strict_types=1);

namespace DnsMadeEasy;

use DnsMadeEasy\Exceptions\Client\Http\BadRequestException;
use DnsMadeEasy\Exceptions\Client\Http\HttpException;
use DnsMadeEasy\Exceptions\Client\Http\NotFoundException;
use DnsMadeEasy\Exceptions\Client\ManagerNotFoundException;
use DnsMadeEasy\Interfaces\ClientInterface;
use DnsMadeEasy\Interfaces\Managers\AbstractManagerInterface;
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
use DnsMadeEasy\Interfaces\PaginatorFactoryInterface;
use DnsMadeEasy\Managers\ContactListManager;
use DnsMadeEasy\Managers\FolderManager;
use DnsMadeEasy\Managers\ManagedDomainManager;
use DnsMadeEasy\Managers\RecordFailoverManager;
use DnsMadeEasy\Managers\SecondaryDomainManager;
use DnsMadeEasy\Managers\SecondaryIPSetManager;
use DnsMadeEasy\Managers\SOARecordManager;
use DnsMadeEasy\Managers\TemplateManager;
use DnsMadeEasy\Managers\TransferAclManager;
use DnsMadeEasy\Managers\UsageManager;
use DnsMadeEasy\Managers\VanityNameServerManager;
use DnsMadeEasy\Pagination\Factories\PaginatorFactory;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * DNS Made Easy API Client SDK
 * @package DnsMadeEasy
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
class Client implements ClientInterface, LoggerAwareInterface
{
    /**
     * The HTTP Client for all requests.
     * @var HttpClientInterface
     */
    protected HttpClientInterface $client;

    /**
     * The DNS Made Easy API Key
     * @var string
     */
    protected string $apiKey;

    /**
     * The DNS Made Easy Secret Key
     * @var string
     */
    protected string $secretKey;

    /**
     * The DNS Made Easy API Endpoint
     * @var string
     */
    protected string $endpoint = 'https://api.dnsmadeeasy.com/V2.0';

    /**
     * The pagination factory to use for paginated resource collections
     * @var PaginatorFactoryInterface|PaginatorFactory
     */
    protected PaginatorFactoryInterface $paginatorFactory;

    /**
     * Logger interface to use for log messages
     * @var LoggerInterface|NullLogger|null
     */
    public LoggerInterface $logger;

    /**
     * A cache of instantiated manager classes.
     * @var array
     */
    protected array $managers = [];

    /**
     * A map of manager names to classes.
     * @var array|string[]
     */
    protected array $managerMap = [
        'contactlists' => ContactListManager::class,
        'domains' => ManagedDomainManager::class,
        'folders' => FolderManager::class,
        'vanity' => VanityNameServerManager::class,
        'templates' => TemplateManager::class,
        'transferacls' => TransferAclManager::class,
        'soarecords' => SOARecordManager::class,
        'secondaryipsets' => SecondaryIPSetManager::class,
        'secondarydomains' => SecondaryDomainManager::class,
        'failover' => RecordFailoverManager::class,
    ];

    /**
     * The ID of the last request to the API.
     * @var string|null
     */
    protected ?string $requestId;

    /**
     * The request limit on the API.
     * @var int|null
     */
    protected ?int $requestLimit;

    /**
     * The number of requests remaining until the limit is hit.
     * @var int|null
     */
    protected ?int $requestsRemaining;

    /**
     * Creates a new client.
     *
     * @param HttpClientInterface|null $client
     * @param PaginatorFactoryInterface|null $paginatorFactory
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        ?HttpClientInterface $client = null,
        ?PaginatorFactoryInterface $paginatorFactory = null,
        ?LoggerInterface $logger = null
    ) {
        // If we weren't given a HTTP client, create a new Guzzle client.
        if ($client === null) {
            $client = new \GuzzleHttp\Client;
        }

        // If we don't have a paginator factory, use our own.
        if ($paginatorFactory === null) {
            $this->paginatorFactory = new PaginatorFactory;
        }

        $this->setHttpClient($client);

        // If we don't have a logger, use the null logger.
        if ($logger === null) {
            $logger = new NullLogger();
        }
        $this->logger = $logger;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setHttpClient(HttpClientInterface $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->client;
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setApiKey(string $key): self
    {
        $this->apiKey = $key;
        return $this;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setSecretKey(string $key): self
    {
        $this->secretKey = $key;
        return $this;
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    public function setPaginatorFactory(PaginatorFactoryInterface $factory): self
    {
        $this->paginatorFactory = $factory;
        return $this;
    }

    public function getPaginatorFactory(): PaginatorFactoryInterface
    {
        return $this->paginatorFactory;
    }

    public function get(string $url, array $params = []): ResponseInterface
    {
        $queryString = '';
        if ($params) {
            $queryString = '?' . http_build_query($params);
        }
        $url .= $queryString;

        $request = new Request('GET', $this->endpoint . $url);
        return $this->send($request);
    }

    public function post(string $url, $payload): ResponseInterface
    {
        $request = new Request('POST', $this->endpoint . $url, [], 'php://temp');
        $request->withHeader('Content-Type', 'application/json');
        $request->getBody()->write(json_encode($payload));
        return $this->send($request);
    }

    public function put(string $url, $payload): ResponseInterface
    {
        $request = new Request('PUT', $this->endpoint . $url, [], 'php://temp');
        $request->withHeader('Content-Type', 'application/json');
        $request->getBody()->write(json_encode($payload));
        return $this->send($request);
    }

    public function delete(string $url, $payload = null): ResponseInterface
    {
        $request = new Request('DELETE', $this->endpoint . $url);
        if ($payload) {
            $request->withHeader('Content-Type', 'application/json');
            $request->getBody()->write(json_encode($payload));
        }
        return $this->send($request);
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        $this->logger->debug("[DnsMadeEasy] API Request: {$request->getMethod()} {$request->getUri()}");

        $request = $request->withHeader('Accept', 'application/json');
        $request = $this->addAuthHeaders($request);
        $response = $this->client->sendRequest($request);

        $this->logger->debug("[DnsMadeEasy] API Response: {$response->getStatusCode()} {$response->getReasonPhrase()}");
        $this->updateLimits($response);
        $statusCode = $response->getStatusCode();
        if ((int)substr((string)$statusCode, 0, 1) <= 3) {
            return $response;
        } else {
            $lookup = [
                400 => BadRequestException::class,
                404 => NotFoundException::class,
            ];
            if (array_key_exists($statusCode, $lookup)) {
                $exceptionClass = $lookup[$statusCode];
            } else {
                $exceptionClass = HttpException::class;
            }
            $exception = new $exceptionClass($response->getReasonPhrase(), $statusCode);
            $exception->setRequest($request);
            $exception->setResponse($response);
            throw $exception;
        }
    }

    /**
     * Fetch the API request details from the last API response.
     * @param ResponseInterface $response
     */
    protected function updateLimits(ResponseInterface $response)
    {
        $this->requestId = current($response->getHeader('x-dnsme-requestId'));
        if ($this->requestId === false) {
            $this->requestId = null;
        }

        $this->requestsRemaining = (int)current($response->getHeader('x-dnsme-requestsRemaining'));
        if ($this->requestsRemaining === false) {
            $this->requestsRemaining = null;
        }

        $this->requestLimit = (int)current($response->getHeader('x-dnsme-requestLimit'));
        if ($this->requestLimit === false) {
            $this->requestLimit = null;
        }
    }

    /**
     * Return the ID of the last API request.
     * @return string|null
     */
    public function getLastRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * Get the request limit.
     * @return int|null
     */
    public function getRequestLimit(): ?int
    {
        return $this->requestLimit;
    }

    /**
     * Get the number of requests remaining before you hit the request limit.
     * @return int|null
     */
    public function getRequestsRemaining(): ?int
    {
        return $this->requestsRemaining;
    }

    /**
     * Adds auth headers to requests. These are generated based on the Api Key and the Secret Key.
     * @param RequestInterface $request
     * @return RequestInterface
     * @throws \Exception
     */
    protected function addAuthHeaders(RequestInterface $request): RequestInterface
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $timestamp = $now->format('r');
        $hmac = hash_hmac('sha1', $timestamp, $this->getSecretKey());

        $request = $request->withHeader('x-dnsme-apiKey', $this->getApiKey());
        $request = $request->withHeader('x-dnsme-requestDate', $timestamp);
        $request = $request->withHeader('x-dnsme-hmac', $hmac);
        return $request;
    }

    /**
     * Check if a manager exists with that name in our manager map.
     * @param $name
     * @return bool
     */
    protected function hasManager($name): bool
    {
        $name = strtolower($name);
        return array_key_exists($name, $this->managerMap);
    }

    /**
     * Gets the manager with the specified name.
     * @param $name
     * @return AbstractManagerInterface
     * @throws ManagerNotFoundException
     */
    protected function getManager($name): AbstractManagerInterface
    {
        if (!$this->hasManager($name)) {
            throw new ManagerNotFoundException;
        }

        $name = strtolower($name);

        if (!isset($this->managers[$name])) {
            $this->managers[$name] = new $this->managerMap[$name]($this);
        }

        return $this->managers[$name];
    }

    public function __get($name)
    {
        // Usage is a special manager and not like the others.
        if ($name == 'usage') {
            if (!isset($this->managers['usage'])) {
                $this->managers['usage'] = new UsageManager($this);
            }
            return $this->managers['usage'];
        }

        // If we have a manager with this name, return it.
        if ($this->hasManager($name)) {
            return $this->getManager($name);
        }
    }
}