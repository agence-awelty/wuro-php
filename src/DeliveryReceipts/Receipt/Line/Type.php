<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\Receipt\Line;

/**
 * Type of the line.
 */
enum Type: string
{
    case PRODUCT = 'product';

    case HEADER = 'header';
}
