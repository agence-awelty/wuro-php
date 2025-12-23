<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptCreateParams;

/**
 * Type de document (delivery par défaut).
 */
enum Type: string
{
    case DELIVERY = 'delivery';
}
