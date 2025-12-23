<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes\AbsenceType;

/**
 * State of the absence type.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
