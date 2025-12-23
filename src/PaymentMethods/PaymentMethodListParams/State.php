<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods\PaymentMethodListParams;

/**
 * Filtrer par état (active/inactive).
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
