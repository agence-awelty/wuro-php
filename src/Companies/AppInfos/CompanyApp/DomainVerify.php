<?php

declare(strict_types=1);

namespace Wuro\Companies\AppInfos\CompanyApp;

/**
 * Domain verification status.
 */
enum DomainVerify: string
{
    case WAITING = 'waiting';

    case VERIFY = 'verify';

    case NONE = 'none';
}
