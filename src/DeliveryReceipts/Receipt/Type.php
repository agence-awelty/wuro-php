<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\Receipt;

/**
 * Type of the receipt.
 */
enum Type: string
{
    case DELIVERY = 'delivery';
}
