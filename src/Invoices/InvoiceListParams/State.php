<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceListParams;

/**
 * Filtre par état de la facture.
 */
enum State: string
{
    case DRAFT = 'draft';

    case WAITING = 'waiting';

    case PAID = 'paid';

    case NOTPAID = 'notpaid';

    case LATE = 'late';

    case INACTIVE = 'inactive';
}
