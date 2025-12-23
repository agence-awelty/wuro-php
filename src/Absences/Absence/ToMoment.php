<?php

declare(strict_types=1);

namespace Wuro\Absences\Absence;

/**
 * Moment of the day when the absence ends.
 */
enum ToMoment: string
{
    case HALF_AM = 'half-am';

    case HALF_PM = 'half-pm';

    case FULL = 'full';
}
