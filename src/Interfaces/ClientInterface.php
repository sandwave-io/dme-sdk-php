<?php
declare(strict_types=1);

namespace DnsMadeEasy\Interfaces;

use DnsMadeEasy\Client;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    public function setHttpClient(HttpClientInterface $client): Client;
    public function getHttpClient(): HttpClientInterface;

    public function setEndpoint(string $endpoint): ClientInterface;
    public function getEndpoint(): string;

    public function setApiKey(string $key): ClientInterface;
    public function getApiKey(): string;

    public function setSecretKey(string $key): ClientInterface;
    public function getSecretKey(): string;

    public function setPaginatorFactory(PaginatorFactoryInterface $factory): ClientInterface;
    public function getPaginatorFactory(): PaginatorFactoryInterface;

    public function get(string $url, array $params = []): ResponseInterface;
    public function post(string $url, $payload): ResponseInterface;
    public function put(string $url, $payload): ResponseInterface;
    public function delete(string $url): ResponseInterface;

    public function send(RequestInterface $request): ResponseInterface;
}