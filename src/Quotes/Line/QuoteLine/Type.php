<?php

declare(strict_types=1);

namespace Wuro\Quotes\Line\QuoteLine;

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
