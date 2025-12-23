<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceListParams;

/**
 * Filtrer par état de l'absence :
 * - **waiting** : En attente de validation
 * - **accepted** : Validée
 * - **rejected** : Refusée
 * - **canceled** : Annulée par le collaborateur
 * - **inactive** : Supprimée (soft delete)
 */
enum State: string
{
    case WAITING = 'waiting';

    case ACCEPTED = 'accepted';

    case REJECTED = 'rejected';

    case CANCELED = 'canceled';

    case INACTIVE = 'inactive';
}
