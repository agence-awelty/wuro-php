<?php

namespace Wuro\Core\Exceptions;

class BadRequestException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Bad Request Exception';
}
