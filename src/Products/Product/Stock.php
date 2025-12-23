<?php

declare(strict_types=1);

namespace Wuro\Products\Product;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type StockShape = array{
 *   forceSell?: bool|null,
 *   nbAlert?: float|null,
 *   nbMin?: float|null,
 *   nbStock?: float|null,
 *   sellValueHt?: float|null,
 *   sellValueTtc?: float|null,
 *   valueHt?: float|null,
 *   valueTtc?: float|null,
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

    #[Optional('sell_value_ht')]
    public ?float $sellValueHt;

    #[Optional('sell_value_ttc')]
    public ?float $sellValueTtc;

    #[Optional('value_ht')]
    public ?float $valueHt;

    #[Optional('value_ttc')]
    public ?float $valueTtc;

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
        ?float $sellValueHt = null,
        ?float $sellValueTtc = null,
        ?float $valueHt = null,
        ?float $valueTtc = null,
    ): self {
        $self = new self;

        null !== $forceSell && $self['forceSell'] = $forceSell;
        null !== $nbAlert && $self['nbAlert'] = $nbAlert;
        null !== $nbMin && $self['nbMin'] = $nbMin;
        null !== $nbStock && $self['nbStock'] = $nbStock;
        null !== $sellValueHt && $self['sellValueHt'] = $sellValueHt;
        null !== $sellValueTtc && $self['sellValueTtc'] = $sellValueTtc;
        null !== $valueHt && $self['valueHt'] = $valueHt;
        null !== $valueTtc && $self['valueTtc'] = $valueTtc;

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

    public function withSellValueHt(float $sellValueHt): self
    {
        $self = clone $this;
        $self['sellValueHt'] = $sellValueHt;

        return $self;
    }

    public function withSellValueTtc(float $sellValueTtc): self
    {
        $self = clone $this;
        $self['sellValueTtc'] = $sellValueTtc;

        return $self;
    }

    public function withValueHt(float $valueHt): self
    {
        $self = clone $this;
        $self['valueHt'] = $valueHt;

        return $self;
    }

    public function withValueTtc(float $valueTtc): self
    {
        $self = clone $this;
        $self['valueTtc'] = $valueTtc;

        return $self;
    }
}
