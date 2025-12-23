<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Calcule et retourne des statistiques agrégées sur les devis.
 *
 * **Statistiques retournées:**
 * - Totaux HT/TTC par état
 * - Montants min/max
 * - Répartition par type de devis
 *
 * Utilise les mêmes filtres que GET /quotes.
 *
 * @see Wuro\Services\QuotesService::getStats()
 *
 * @phpstan-type QuoteGetStatsParamsShape = array{
 *   maxDate?: \DateTimeInterface|null,
 *   minDate?: \DateTimeInterface|null,
 *   state?: string|null,
 * }
 */
final class QuoteGetStatsParams implements BaseModel
{
    /** @use SdkModel<QuoteGetStatsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?\DateTimeInterface $maxDate;

    #[Optional]
    public ?\DateTimeInterface $minDate;

    #[Optional]
    public ?string $state;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $state = null,
    ): self {
        $self = new self;

        null !== $maxDate && $self['maxDate'] = $maxDate;
        null !== $minDate && $self['minDate'] = $minDate;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    public function withMaxDate(\DateTimeInterface $maxDate): self
    {
        $self = clone $this;
        $self['maxDate'] = $maxDate;

        return $self;
    }

    public function withMinDate(\DateTimeInterface $minDate): self
    {
        $self = clone $this;
        $self['minDate'] = $minDate;

        return $self;
    }

    public function withState(string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
