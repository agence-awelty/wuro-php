<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceUpdateParams;

/**
 * Type de facture.
 */
enum Type: string
{
    case INVOICE = 'invoice';

    case INVOICE_CREDIT = 'invoice_credit';

    case EXTERNAL = 'external';

    case EXTERNAL_CREDIT = 'external_credit';

    case PROFORMA = 'proforma';

    case ADVANCE = 'advance';
}
