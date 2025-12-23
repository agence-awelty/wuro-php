<?php

declare(strict_types=1);

namespace Wuro\Quotes\Line\LineAddParams;

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
