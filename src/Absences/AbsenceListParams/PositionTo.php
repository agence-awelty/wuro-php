<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceListParams;

use Wuro\Core\Concerns\SdkUnion;
use Wuro\Core\Conversion\Contracts\Converter;
use Wuro\Core\Conversion\Contracts\ConverterSource;
use Wuro\Core\Conversion\ListOf;

/**
 * Filtrer par poste concerné. Valeurs spéciales :
 * - **all** : Tous les postes
 * - **onlyActive** : Postes actifs uniquement
 * - ID de poste pour un poste spécifique
 * - Tableau d'IDs pour plusieurs postes
 *
 * @phpstan-type PositionToVariants = string|list<string>
 * @phpstan-type PositionToShape = PositionToVariants
 */
final class PositionTo implements ConverterSource
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
