<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes\AbsenceType;

/**
 * Type of the absence type.
 */
enum Type: string
{
    case ABSENCE = 'absence';

    case EVENT = 'event';
}
