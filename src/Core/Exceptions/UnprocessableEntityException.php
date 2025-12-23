<?php

namespace Wuro\Core\Exceptions;

class UnprocessableEntityException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Unprocessable Entity Exception';
}
