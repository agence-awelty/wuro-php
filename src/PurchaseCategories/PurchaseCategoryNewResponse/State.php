<?php

declare(strict_types=1);

namespace Wuro\PurchaseCategories\PurchaseCategoryNewResponse;

enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
