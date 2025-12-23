<?php

namespace Wuro\Core\Exceptions;

class AuthenticationException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Authentication Exception';
}
