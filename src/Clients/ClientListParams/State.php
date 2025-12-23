<?php

declare(strict_types=1);

namespace Wuro\Clients\ClientListParams;

/**
 * Filtrer par état (active = visible, inactive = archivé).
 */
enum State: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
