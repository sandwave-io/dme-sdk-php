<?php
declare(strict_types=1);

namespace DnsMadeEasy\Exceptions\Client\Http;

use DnsMadeEasy\Exceptions\DnsMadeEasyException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpException extends DnsMadeEasyException
{
    protected ?RequestInterface $request = null;
    protected ?ResponseInterface $response = null;

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}