<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes\AbsenceTypeCreateParams;

/**
 * Catégorie du type :
 * - **absence** : Congés, RTT, maladie (absence du collaborateur)
 * - **event** : Formation, réunion (présent mais non disponible)
 */
enum Type: string
{
    case ABSENCE = 'absence';

    case EVENT = 'event';
}
