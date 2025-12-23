<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceCreateParams\InvoiceLine;

/**
 * Type de ligne.
 */
enum Type: string
{
    case PRODUCT = 'product';

    case HEADER = 'header';

    case SUBTOTAL = 'subtotal';

    case GLOBAL_DISCOUNT = 'globalDiscount';
}
