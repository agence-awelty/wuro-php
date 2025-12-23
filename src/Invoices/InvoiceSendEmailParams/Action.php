<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceSendEmailParams;

/**
 * Type d'envoi (envoi ou relance).
 */
enum Action: string
{
    case SEND_INVOICE = 'send_invoice';

    case DUNNING_INVOICE = 'dunning_invoice';
}
