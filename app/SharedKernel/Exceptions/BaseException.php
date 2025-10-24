<?php

namespace App\SharedKernel\Exceptions;

use Exception;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class BaseException extends Exception implements HttpExceptionInterface
{
    public function __construct($message = '', $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->getHttpStatusCode() === 0 ? 500 : $this->getHttpStatusCode();
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getHttpStatusCode(): int
    {
        return $this->getCode();
    }
}
