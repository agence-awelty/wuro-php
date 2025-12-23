<?php

declare(strict_types=1);

namespace Wuro\Quotes\QuoteListParams;

/**
 * Filtre par type de document.
 */
enum Type: string
{
    case QUOTE = 'quote';

    case PROFORMA = 'proforma';

    case BDC = 'bdc';
}
