<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods\PaymentMethodUpdateParams;

/**
 * Type de moyen de paiement :
 * - **check** : Chèque
 * - **transfer** : Virement bancaire
 * - **stripe** : Stripe
 * - **paypal** : PayPal
 * - **paybox** : Paybox
 * - **epayment** : Paiement électronique
 * - **other** : Autre
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
