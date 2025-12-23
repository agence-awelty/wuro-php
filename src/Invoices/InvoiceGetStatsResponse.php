<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceGetStatsResponseShape = array{
 *   max?: float|null, min?: float|null, stats?: mixed
 * }
 */
final class InvoiceGetStatsResponse implements BaseModel
{
    /** @use SdkModel<InvoiceGetStatsResponseShape> */
    use SdkModel;

    /**
     * Montant maximum.
     */
    #[Optional]
    public ?float $max;

    /**
     * Montant minimum.
     */
    #[Optional]
    public ?float $min;

    /**
     * Statistiques agrégées.
     */
    #[Optional]
    public mixed $stats;

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
        ?float $max = null,
        ?float $min = null,
        mixed $stats = null
    ): self {
        $self = new self;

        null !== $max && $self['max'] = $max;
        null !== $min && $self['min'] = $min;
        null !== $stats && $self['stats'] = $stats;

        return $self;
    }

    /**
     * Montant maximum.
     */
    public function withMax(float $max): self
    {
        $self = clone $this;
        $self['max'] = $max;

        return $self;
    }

    /**
     * Montant minimum.
     */
    public function withMin(float $min): self
    {
        $self = clone $this;
        $self['min'] = $min;

        return $self;
    }

    /**
     * Statistiques agrégées.
     */
    public function withStats(mixed $stats): self
    {
        $self = clone $this;
        $self['stats'] = $stats;

        return $self;
    }
}
