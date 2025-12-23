<?php

declare(strict_types=1);

namespace Wuro\Purchases\PurchaseListParams;

/**
 * Filtrer par état de l'achat.
 */
enum State: string
{
    case DRAFT = 'draft';

    case WAITING = 'waiting';

    case PAID = 'paid';

    case TO_PAY = 'to_pay';

    case NOTPAID = 'notpaid';

    case INACTIVE = 'inactive';
}
