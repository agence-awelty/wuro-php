<?php

declare(strict_types=1);

namespace Wuro\Quotes\QuoteCreateParams;

/**
 * Type de document.
 */
enum Type: string
{
    case QUOTE = 'quote';

    case PROFORMA = 'proforma';

    case BDC = 'bdc';
}
