<?php

declare(strict_types=1);

namespace Wuro\Users\UserUpdateParams;

/**
 * Genre.
 */
enum Gender: string
{
    case H = 'H';

    case F = 'F';

    case OTHER = 'Other';
}
