<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceCreateParams;

/**
 * État initial de l'absence (waiting par défaut).
 */
enum State: string
{
    case WAITING = 'waiting';

    case ACCEPTED = 'accepted';

    case REJECTED = 'rejected';

    case CANCELED = 'canceled';
}
