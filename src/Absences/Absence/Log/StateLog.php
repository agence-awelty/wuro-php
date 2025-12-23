<?php

declare(strict_types=1);

namespace Wuro\Absences\Absence\Log;

/**
 * State of the log.
 */
enum StateLog: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
