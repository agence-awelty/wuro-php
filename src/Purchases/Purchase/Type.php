<?php

declare(strict_types=1);

namespace Wuro\Purchases\Purchase;

enum Type: string
{
    case PURCHASE_OLD = 'purchase_old';

    case PURCHASE = 'purchase';

    case PURCHASE_CREDIT = 'purchase_credit';
}
