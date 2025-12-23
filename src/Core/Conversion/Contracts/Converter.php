<?php

declare(strict_types=1);

namespace Wuro\Core\Conversion\Contracts;

use Wuro\Core\Conversion\CoerceState;
use Wuro\Core\Conversion\DumpState;

/**
 * @internal
 */
interface Converter
{
    /**
     * @internal
     */
    public function coerce(mixed $value, CoerceState $state): mixed;

    /**
     * @internal
     */
    public function dump(mixed $value, DumpState $state): mixed;
}
