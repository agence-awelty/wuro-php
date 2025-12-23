<?php

declare(strict_types=1);

namespace Wuro\PurchaseCategories\PurchaseCategoryGetResponse;

enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
