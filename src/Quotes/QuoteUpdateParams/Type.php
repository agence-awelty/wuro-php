<?php

declare(strict_types=1);

namespace Wuro\Quotes\QuoteUpdateParams;

enum Type: string
{
    case QUOTE = 'quote';

    case PROFORMA = 'proforma';

    case BDC = 'bdc';
}
