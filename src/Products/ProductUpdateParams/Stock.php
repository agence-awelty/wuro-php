<?php

declare(strict_types=1);

namespace Wuro\Products\ProductUpdateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type StockShape = array{
 *   forceSell?: bool|null,
 *   nbAlert?: float|null,
 *   nbMin?: float|null,
 *   nbStock?: float|null,
 * }
 */
final class Stock implements BaseModel
{
    /** @use SdkModel<StockShape> */
    use SdkModel;

    #[Optional]
    public ?bool $forceSell;

    #[Optional('nb_alert')]
    public ?float $nbAlert;

    #[Optional('nb_min')]
    public ?float $nbMin;

    #[Optional('nb_stock')]
    public ?float $nbStock;

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
        ?bool $forceSell = null,
        ?float $nbAlert = null,
        ?float $nbMin = null,
        ?float $nbStock = null,
    ): self {
        $self = new self;

        null !== $forceSell && $self['forceSell'] = $forceSell;
        null !== $nbAlert && $self['nbAlert'] = $nbAlert;
        null !== $nbMin && $self['nbMin'] = $nbMin;
        null !== $nbStock && $self['nbStock'] = $nbStock;

        return $self;
    }

    public function withForceSell(bool $forceSell): self
    {
        $self = clone $this;
        $self['forceSell'] = $forceSell;

        return $self;
    }

    public function withNbAlert(float $nbAlert): self
    {
        $self = clone $this;
        $self['nbAlert'] = $nbAlert;

        return $self;
    }

    public function withNbMin(float $nbMin): self
    {
        $self = clone $this;
        $self['nbMin'] = $nbMin;

        return $self;
    }

    public function withNbStock(float $nbStock): self
    {
        $self = clone $this;
        $self['nbStock'] = $nbStock;

        return $self;
    }
}
