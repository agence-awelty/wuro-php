<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\Receipt;

/**
 * State of the delivery receipt.
 */
enum State: string
{
    case DRAFT = 'draft';

    case WAITING = 'waiting';

    case SHIPPED = 'shipped';

    case DELIVERED = 'delivered';

    case REFUSED = 'refused';

    case CANCELED = 'canceled';

    case INACTIVE = 'inactive';
}
