<?php

namespace Wuro\Core\Exceptions;

use Psr\Http\Message\RequestInterface;

class APITimeoutException extends APIConnectionException
{
    /** @var string */
    protected const DESC = 'Wuro API Timeout Exception';

    public function __construct(
        RequestInterface $request,
        ?\Throwable $previous = null,
        string $message = 'Request timed out.',
    ) {
        parent::__construct(request: $request, message: $message, previous: $previous);
    }
}
