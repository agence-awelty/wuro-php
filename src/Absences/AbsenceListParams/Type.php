<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceListParams;

use Wuro\Core\Concerns\SdkUnion;
use Wuro\Core\Conversion\Contracts\Converter;
use Wuro\Core\Conversion\Contracts\ConverterSource;
use Wuro\Core\Conversion\ListOf;

/**
 * Filtrer par type d'absence (peut être un tableau).
 *
 * @phpstan-type TypeVariants = string|list<string>
 * @phpstan-type TypeShape = TypeVariants
 */
final class Type implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf('string')];
    }
}
