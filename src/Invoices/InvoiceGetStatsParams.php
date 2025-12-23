<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Calcule et retourne des statistiques agrégées sur les factures.
 *
 * **Statistiques retournées:**
 * - Totaux HT/TTC par état
 * - Montants min/max
 * - Répartition par type de facture
 *
 * Utilise les mêmes filtres que GET /invoices (state, type, client, dates, etc.)
 *
 * @see Wuro\Services\InvoicesService::getStats()
 *
 * @phpstan-type InvoiceGetStatsParamsShape = array{
 *   maxDate?: \DateTimeInterface|null,
 *   minDate?: \DateTimeInterface|null,
 *   state?: string|null,
 * }
 */
final class InvoiceGetStatsParams implements BaseModel
{
    /** @use SdkModel<InvoiceGetStatsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?\DateTimeInterface $maxDate;

    #[Optional]
    public ?\DateTimeInterface $minDate;

    /**
     * Filtre par état.
     */
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

    /**
     * Filtre par état.
     */
    public function withState(string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
