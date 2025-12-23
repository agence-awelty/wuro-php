<?php

declare(strict_types=1);

namespace Wuro\Quotes\Line\Quote;

/**
 * Type of the quote.
 */
enum Type: string
{
    case QUOTE = 'quote';

    case PROFORMA = 'proforma';

    case BDC = 'bdc';
}
