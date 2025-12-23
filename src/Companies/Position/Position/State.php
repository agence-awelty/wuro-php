<?php

declare(strict_types=1);

namespace Wuro\Companies\Position\Position;

/**
 * State of the position.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
