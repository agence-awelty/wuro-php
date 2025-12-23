<?php

declare(strict_types=1);

namespace Wuro\Core\Conversion;

use Wuro\Core\Conversion\Concerns\ArrayOf;
use Wuro\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class ListOf implements Converter
{
    use ArrayOf;

    // @phpstan-ignore-next-line missingType.iterableValue
    private function empty(): array|object
    {
        return [];
    }
}
