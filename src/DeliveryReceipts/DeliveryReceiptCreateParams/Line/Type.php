<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line;

/**
 * Type de ligne :
 * - **product** : Ligne produit standard
 * - **header** : Ligne de titre/séparation
 */
enum Type: string
{
    case PRODUCT = 'product';

    case HEADER = 'header';
}
