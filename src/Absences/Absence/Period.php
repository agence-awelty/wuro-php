<?php

declare(strict_types=1);

namespace Wuro\Absences\Absence;

/**
 * Period type of the absence.
 */
enum Period: string
{
    case PERIOD = 'period';

    case FULL = 'full';

    case HALF = 'half';
}
