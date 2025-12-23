<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes\AbsenceTypeUpdateParams;

/**
 * État du type (inactive = masqué dans les choix).
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
