<?php
declare(strict_types=1);

namespace DnsMadeEasy\Contracts;

use DnsMadeEasy\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ClientContract
{
    public function setHttpClient(ClientInterface $client): Client;

    public function getHttpClient(): ClientInterface;

    public function setApiKey(string $key): Client;

    public function getApiKey(): string;

    public function setSecretKey(string $key): Client;

    public function getSecretKey(): string;

    public function get(string $url, array $params = []): ResponseInterface;

    public function post(string $url, array $params): ResponseInterface;

    public function put(string $url, array $params): ResponseInterface;

    public function delete(string $url): ResponseInterface;

    public function send(RequestInterface $request): ResponseInterface;
}