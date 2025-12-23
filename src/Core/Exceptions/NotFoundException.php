<?php

namespace Wuro\Core\Exceptions;

class NotFoundException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Not Found Exception';
}
