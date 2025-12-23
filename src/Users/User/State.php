<?php

declare(strict_types=1);

namespace Wuro\Users\User;

/**
 * User's state.
 */
enum State: string
{
    case INACTIVE = 'inactive';

    case CREATED = 'created';

    case CONFIRMED = 'confirmed';

    case LINKEDIN = 'linkedin';

    case GOOGLE = 'google';

    case DELETED = 'deleted';
}
