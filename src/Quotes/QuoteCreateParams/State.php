<?php

declare(strict_types=1);

namespace Wuro\Quotes\QuoteCreateParams;

/**
 * État initial.
 */
enum State: string
{
    case DRAFT = 'draft';

    case PENDING = 'pending';

    case WAITING = 'waiting';

    case ACCEPTED = 'accepted';

    case REFUSED = 'refused';
}
