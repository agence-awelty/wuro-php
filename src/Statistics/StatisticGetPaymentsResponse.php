<?php

declare(strict_types=1);

namespace Wuro\Statistics;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type StatisticGetPaymentsResponseShape = array{
 *   average?: float|null, byMethod?: mixed, count?: int|null, total?: float|null
 * }
 */
final class StatisticGetPaymentsResponse implements BaseModel
{
    /** @use SdkModel<StatisticGetPaymentsResponseShape> */
    use SdkModel;

    /**
     * Montant moyen par paiement.
     */
    #[Optional]
    public ?float $average;

    /**
     * Répartition par mode de paiement.
     */
    #[Optional]
    public mixed $byMethod;

    /**
     * Nombre de paiements.
     */
    #[Optional]
    public ?int $count;

    /**
     * Montant total des paiements.
     */
    #[Optional]
    public ?float $total;

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
        ?float $average = null,
        mixed $byMethod = null,
        ?int $count = null,
        ?float $total = null,
    ): self {
        $self = new self;

        null !== $average && $self['average'] = $average;
        null !== $byMethod && $self['byMethod'] = $byMethod;
        null !== $count && $self['count'] = $count;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Montant moyen par paiement.
     */
    public function withAverage(float $average): self
    {
        $self = clone $this;
        $self['average'] = $average;

        return $self;
    }

    /**
     * Répartition par mode de paiement.
     */
    public function withByMethod(mixed $byMethod): self
    {
        $self = clone $this;
        $self['byMethod'] = $byMethod;

        return $self;
    }

    /**
     * Nombre de paiements.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Montant total des paiements.
     */
    public function withTotal(float $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
