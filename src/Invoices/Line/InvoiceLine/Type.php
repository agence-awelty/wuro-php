<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line\InvoiceLine;

/**
 * Type of the line.
 */
enum Type: string
{
    case PRODUCT = 'product';

    case HEADER = 'header';

    case SUBTOTAL = 'subtotal';

    case GLOBAL_DISCOUNT = 'globalDiscount';
}
