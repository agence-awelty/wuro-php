<?php

declare(strict_types=1);

namespace Wuro\Quotes\QuoteUpdateParams;

/**
 * État du devis.
 */
enum State: string
{
    case DRAFT = 'draft';

    case PENDING = 'pending';

    case WAITING = 'waiting';

    case ACCEPTED = 'accepted';

    case REFUSED = 'refused';

    case INVOICED = 'invoiced';

    case CANCELED = 'canceled';
}
