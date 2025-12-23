<?php

namespace Wuro\Core\Exceptions;

class RateLimitException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Rate Limit Exception';
}
