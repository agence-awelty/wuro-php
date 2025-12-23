<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods\PaymentMethod;

/**
 * Type of payment method.
 */
enum Tag: string
{
    case PAYBOX = 'paybox';

    case EPAYMENT = 'epayment';

    case CHECK = 'check';

    case STRIPE = 'stripe';

    case PAYPAL = 'paypal';

    case TRANSFER = 'transfer';

    case OTHER = 'other';
}
