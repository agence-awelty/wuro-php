<?php

declare(strict_types=1);

namespace Wuro\ProductCategories\ProductCategoryUpdateParams;

/**
 * État de la catégorie.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
