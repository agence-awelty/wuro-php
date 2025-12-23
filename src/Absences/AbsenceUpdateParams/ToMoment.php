<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceUpdateParams;

/**
 * Moment de fin :
 * - **full** : Journée entière
 * - **half-am** : Matin uniquement
 * - **half-pm** : Après-midi uniquement
 */
enum ToMoment: string
{
    case HALF_AM = 'half-am';

    case HALF_PM = 'half-pm';

    case FULL = 'full';
}
