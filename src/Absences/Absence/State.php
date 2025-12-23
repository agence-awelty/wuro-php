<?php

declare(strict_types=1);

namespace Wuro\Absences\Absence;

/**
 * State of the absence.
 */
enum State: string
{
    case WAITING = 'waiting';

    case ACCEPTED = 'accepted';

    case REJECTED = 'rejected';

    case CANCELED = 'canceled';

    case INACTIVE = 'inactive';
}
