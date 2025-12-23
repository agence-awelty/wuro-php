<?php

declare(strict_types=1);

namespace Wuro\PurchaseCategories\PurchaseCategoryUpdateParams;

/**
 * État de la catégorie.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
