<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type VatRateShape = array{
 *   amount?: float|null, rate?: string|null, total?: float|null
 * }
 */
final class VatRate implements BaseModel
{
    /** @use SdkModel<VatRateShape> */
    use SdkModel;

    /**
     * Amount of VAT.
     */
    #[Optional]
    public ?float $amount;

    /**
     * VAT rate.
     */
    #[Optional]
    public ?string $rate;

    /**
     * Total amount with this VAT rate.
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
        ?float $amount = null,
        ?string $rate = null,
        ?float $total = null
    ): self {
        $self = new self;

        null !== $amount && $self['amount'] = $amount;
        null !== $rate && $self['rate'] = $rate;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Amount of VAT.
     */
    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * VAT rate.
     */
    public function withRate(string $rate): self
    {
        $self = clone $this;
        $self['rate'] = $rate;

        return $self;
    }

    /**
     * Total amount with this VAT rate.
     */
    public function withTotal(float $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
