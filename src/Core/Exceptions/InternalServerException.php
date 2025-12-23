<?php

namespace Wuro\Core\Exceptions;

class InternalServerException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Internal Server Exception';
}
