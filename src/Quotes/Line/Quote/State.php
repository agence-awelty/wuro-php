<?php

declare(strict_types=1);

namespace Wuro\Quotes\Line\Quote;

/**
 * State of the quote.
 */
enum State: string
{
    case INVOICED = 'invoiced';

    case REFUSED = 'refused';

    case ACCEPTED = 'accepted';

    case WAITING = 'waiting';

    case DRAFT = 'draft';

    case CANCELED = 'canceled';

    case INACTIVE = 'inactive';
}
