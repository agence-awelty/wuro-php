<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptCreateParams;

/**
 * État initial du bon.
 */
enum State: string
{
    case DRAFT = 'draft';

    case WAITING = 'waiting';

    case SHIPPED = 'shipped';

    case DELIVERED = 'delivered';
}
