<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Exceptions\Client\Http;

use DnsMadeEasy\Exceptions\DnsMadeEasyException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Represents an exception while communicating with the DnsMadeEasy API.
 *
 * @package DnsMadeEasy\Exceptions\HTTP
 */
class HttpException extends DnsMadeEasyException
{
    /**
     * The request that was made when the exception was thrown.
     *
     * @var RequestInterface|null
     */
    protected ?RequestInterface $request = null;

    /**
     * The response to the request.
     *
     * @var ResponseInterface|null
     */
    protected ?ResponseInterface $response = null;

    /**
     * Set the request that caused the exception.
     *
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Get the request that caused the exception.
     *
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    /**
     * Set the response that caused the exception.
     *
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get the response that caused the exception.
     *
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
