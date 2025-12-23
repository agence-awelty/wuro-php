<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes\AbsenceTypeCreateParams;

/**
 * État initial (active par défaut).
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
