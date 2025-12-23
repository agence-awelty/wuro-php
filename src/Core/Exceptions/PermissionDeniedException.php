<?php

namespace Wuro\Core\Exceptions;

class PermissionDeniedException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Wuro Permission Denied Exception';
}
