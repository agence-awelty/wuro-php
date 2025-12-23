<?php

declare(strict_types=1);

namespace Wuro\Companies\Position\PositionUpdateParams;

/**
 * État du poste.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
