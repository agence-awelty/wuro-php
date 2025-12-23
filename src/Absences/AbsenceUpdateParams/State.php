<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceUpdateParams;

/**
 * Nouvel état de l'absence :
 * - **waiting** : En attente de validation
 * - **accepted** : Validée par le responsable
 * - **rejected** : Refusée par le responsable
 * - **canceled** : Annulée par le collaborateur
 */
enum State: string
{
    case WAITING = 'waiting';

    case ACCEPTED = 'accepted';

    case REJECTED = 'rejected';

    case CANCELED = 'canceled';

    case INACTIVE = 'inactive';
}
