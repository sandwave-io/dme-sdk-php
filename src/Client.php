<?php
declare(strict_types=1);

namespace DnsMadeEasy;

use DnsMadeEasy\Contracts\ClientContract;
use DnsMadeEasy\Factories\ContactListFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;

class Client implements ClientContract
{
	protected $client;
	protected $apiKey;
	protected $secretKey;

	protected $factories = [];

	protected $factoryMap = [
	    'contactlists' => ContactListFactory::class,
    ];

	public function __construct(?ClientInterface $client = null)
	{
		if ($client === null && class_exists('\GuzzleHttp\Client')) {
			$client = new \GuzzleHttp\Client;
		}

		$this->setHttpClient($client);
	}

	public function setHttpClient(ClientInterface $client): self
	{
		$this->client = $client;
		return $this;
	}

	public function getHttpClient(): ClientInterface
	{
		return $this->client;
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

	public function get(string $url, array $params = []): ResponseInterface
	{
		$queryString = '';
		if ($params) {
			$queryString = '?' . http_build_query($params);
		}
		$url .= $queryString;

		$request = new Request('GET', $url);
		return $this->send($request);
	}

	public function post(string $url, array $params): ResponseInterface
	{
		$request = new Request('POST', $url, 'php://temp');
		$request->withHeader('Content-Type', 'application/json');
		$request->getBody()->write(json_encode($params));
		return $this->send($request);
	}

	public function put(string $url, array $params): ResponseInterface
	{
		$request = new Request('PUT', $url, 'php://temp');
		$request->withHeader('Content-Type', 'application/json');
		$request->getBody()->write(json_encode($params));
		return $this->send($request);
	}

	public function delete(string $url): ResponseInterface
	{
		$request = new Request('DELETE', $url);
		return $this->send($request);
	}

	public function send(RequestInterface $request): ResponseInterface
	{
		$request = $request->withHeader('Accept', 'application/json');
		$request = $this->addAuthHeaders($request);
		return $this->client->sendRequest($request);
	}

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

	protected function hasFactory($name)
    {
        $name = strtolower($name);
        return array_key_exists($name, $this->factoryMap);
    }

    protected function getFactory($name)
    {
        if (!$this->hasFactory($name)) {
            return;
        }

        $name = strtolower($name);

        if (!isset($this->factories[$name])) {
            $this->factories[$name] = new $this->factoryMap[$name]($this);
        }

        return $this->factories[$name];
    }

	public function __get($name)
    {
        if ($this->hasFactory($name)) {
            return $this->getFactory($name);
        }
    }

    public function __call($name, $args)
    {
        if ($this->hasFactory($name)) {
            return $this->getFactory($name);
        }
    }
}