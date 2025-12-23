<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods\PaymentMethodListParams;

/**
 * Filtrer par type de moyen de paiement.
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
