<?php

namespace Recipes\Application\Query\Session;

use LIN3S\SharedKernel\Exception\DomainException;
use Throwable;

class APISessionErrorException extends DomainException
{
    private $statusCode;

    public function __construct(
        string $message = "",
        int $statusCode = 400,
        int $code = 0
    )
    {
        parent::__construct($message, $code, null);
        $this->statusCode = $statusCode;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}