<?php

declare(strict_types=1);

namespace Wuro\Quotes\QuoteCreateParams\QuoteLine;

enum Type: string
{
    case PRODUCT = 'product';

    case HEADER = 'header';

    case SUBTOTAL = 'subtotal';

    case GLOBAL_DISCOUNT = 'globalDiscount';
}
