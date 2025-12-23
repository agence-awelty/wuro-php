<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceCreateParams;

/**
 * État initial (draft = brouillon sans numéro).
 */
enum State: string
{
    case DRAFT = 'draft';

    case WAITING = 'waiting';

    case PAID = 'paid';

    case NOTPAID = 'notpaid';

    case LATE = 'late';
}
