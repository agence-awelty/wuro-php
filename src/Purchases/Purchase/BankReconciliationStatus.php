<?php

declare(strict_types=1);

namespace Wuro\Purchases\Purchase;

enum BankReconciliationStatus: string
{
    case UNRECONCILIATED = 'unreconciliated';

    case RECONCILIATED = 'reconciliated';

    case PARTIALRECONCILIATED = 'partialreconciliated';
}
