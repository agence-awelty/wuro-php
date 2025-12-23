<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes\AbsenceTypeListParams;

/**
 * Filtrer par catégorie (absence ou event).
 */
enum Type: string
{
    case ABSENCE = 'absence';

    case EVENT = 'event';
}
