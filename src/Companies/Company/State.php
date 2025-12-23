<?php

declare(strict_types=1);

namespace Wuro\Companies\Company;

/**
 * State of the company.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';

    case DELETED = 'deleted';
}
