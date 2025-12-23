<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceListWaitingPaymentsParams;

enum State: string
{
    case WAITING = 'waiting';

    case LATE = 'late';
}
