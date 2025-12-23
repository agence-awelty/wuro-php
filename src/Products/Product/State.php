<?php

declare(strict_types=1);

namespace Wuro\Products\Product;

enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
