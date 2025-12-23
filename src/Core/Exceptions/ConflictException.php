<?php

namespace Wuro\Core\Exceptions;

class ConflictException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Conflict Exception';
}
