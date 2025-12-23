<?php

declare(strict_types=1);

namespace Wuro\Clients\Client;

/**
 * Client state.
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
