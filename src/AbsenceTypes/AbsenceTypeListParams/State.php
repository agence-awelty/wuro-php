<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes\AbsenceTypeListParams;

/**
 * Filtrer par état (active/inactive).
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
