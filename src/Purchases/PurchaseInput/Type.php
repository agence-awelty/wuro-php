<?php

declare(strict_types=1);

namespace Wuro\Purchases\PurchaseInput;

enum Type: string
{
    case PURCHASE = 'purchase';

    case PURCHASE_CREDIT = 'purchase_credit';
}
