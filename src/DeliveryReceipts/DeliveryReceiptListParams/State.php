<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptListParams;

/**
 * Filtre par état.
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
