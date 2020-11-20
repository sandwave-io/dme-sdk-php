<?php
declare(strict_types=1);

namespace DnsMadeEasy;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
	const VERSION = '1.0.0';

	protected $client;
	protected $factory;

	public function __construct(?ClientInterface $client = null)
	{
		if ($client === null) {
			// No client, attempt to create one using Guzzle
			if (class_exists('\GuzzleHttp\Client')) {
				$client = new \GuzzleHttp\Client;
			} elseif (class_exists('\Http\Adapter\Guzzle6\Client')) {
				$client = new \Http\Adapter\Guzzle6\Client;
			}
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

	public function get(string $url, array $params = []): ResponseInterface
	{
		$queryString = '?' . http_build_query($params);
		$url .= $queryString;

		$request = new Request($url, 'GET');
		return $this->send($request);
	}

	public function post(string $url, array $params): ResponseInterface
	{
		$request = new Request($url, 'POST', 'php://temp', ['content-type' => 'application/json']);
		$request->getBody()->write(json_encode($params));
		return $this->send($request);
	}

	public function put(string $url, array $params): ResponseInterface
	{
		$request = new Request($url, 'PUT', 'php://temp', ['content-type' => 'application/json']);
		$request->getBody()->write(json_encode($params));
		return $this->send($request);
	}

	public function delete(string $url): ResponseInterface
	{
		$request = new Request($url, 'DELETE');
		return $this->send($request);
	}

	public function send(RequestInterface $request): ResponseInterface
	{
		$request = $this->setUserAgent($request);
		$response = $this->client->sendRequest($request);
	}

	protected function setUserAgent(RequestInterface $request): RequestInterface
	{
		$userAgent = [];
		$userAgent[] = 'dns-made-easy/' . $this->getVersion();
		$userAgent[] = 'php/' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;
		return $request->withHeader('User-Agent', implode(' ', $userAgent));
	}

	public function getVersion(): string
	{
		return self::VERSION;
	}
}