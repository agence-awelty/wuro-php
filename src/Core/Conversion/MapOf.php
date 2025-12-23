<?php

declare(strict_types=1);

namespace Wuro\Core\Conversion;

use Wuro\Core\Conversion\Concerns\ArrayOf;
use Wuro\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class MapOf implements Converter
{
    use ArrayOf;
}
