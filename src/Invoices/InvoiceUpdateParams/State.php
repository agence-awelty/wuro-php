<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceUpdateParams;

/**
 * État de la facture.
 */
enum State: string
{
    case DRAFT = 'draft';

    case WAITING = 'waiting';

    case PAID = 'paid';

    case NOTPAID = 'notpaid';

    case LATE = 'late';
}
