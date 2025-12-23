<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line\Invoice;

/**
 * Type of the invoice.
 */
enum Type: string
{
    case INVOICE = 'invoice';

    case CREDIT = 'credit';

    case SOLD = 'sold';

    case ADVANCE = 'advance';

    case EXTERNAL = 'external';

    case EXTERNAL_CREDIT = 'external_credit';
}
