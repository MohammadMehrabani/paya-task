<?php

namespace App\SharedKernel\Exceptions;

class ErrorException extends BaseException
{
    public function report(): void
    {
        // 
    }

    public function __construct($message = 'The process could not be done', $code = 400)
    {
        parent::__construct($message, $code);
    }

    public static function make(string $message = 'The process could not be done', int $code = 400): static
    {
        return new static(__($message), $code);
    }

    public static function fromException(\Exception $previous): static
    {
        return new static(__($previous->getMessage()));
    }
}
