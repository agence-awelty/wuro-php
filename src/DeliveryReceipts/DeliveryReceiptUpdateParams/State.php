<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams;

/**
 * État du bon de livraison :
 * - **draft** : Brouillon
 * - **waiting** : En attente d'expédition
 * - **shipped** : Expédié
 * - **delivered** : Livré
 * - **refused** : Refusé
 * - **canceled** : Annulé
 */
enum State: string
{
    case DRAFT = 'draft';

    case WAITING = 'waiting';

    case SHIPPED = 'shipped';

    case DELIVERED = 'delivered';

    case REFUSED = 'refused';

    case CANCELED = 'canceled';

    case INACTIVE = 'inactive';
}
