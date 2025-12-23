<?php

declare(strict_types=1);

namespace Wuro\Quotes\Line\Quote\Acompte;

/**
 * Type of payment.
 */
enum Type: string
{
    case ADVANCE = 'advance';

    case SOLD = 'sold';

    case CREDIT = 'credit';

    case INVOICE = 'invoice';
}
