<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods\PaymentMethodUpdateParams;

/**
 * État du moyen de paiement.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
