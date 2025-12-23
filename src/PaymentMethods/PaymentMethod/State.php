<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods\PaymentMethod;

/**
 * State of the payment method.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
