<?php

declare(strict_types=1);

namespace Wuro\PurchaseCategories\PurchaseCategoryListResponse\Data;

enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
