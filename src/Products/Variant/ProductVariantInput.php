<?php

declare(strict_types=1);

namespace Wuro\Products\Variant;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Products\Variant\ProductVariantInput\Stock;

/**
 * @phpstan-import-type StockShape from \Wuro\Products\Variant\ProductVariantInput\Stock
 *
 * @phpstan-type ProductVariantInputShape = array{
 *   buyingPrice?: float|null,
 *   name?: string|null,
 *   options?: mixed,
 *   priceHt?: float|null,
 *   reference?: string|null,
 *   sku?: string|null,
 *   stock?: null|Stock|StockShape,
 *   tvaRate?: float|null,
 * }
 */
final class ProductVariantInput implements BaseModel
{
    /** @use SdkModel<ProductVariantInputShape> */
    use SdkModel;

    #[Optional('buying_price')]
    public ?float $buyingPrice;

    #[Optional]
    public ?string $name;

    #[Optional]
    public mixed $options;

    #[Optional('price_ht')]
    public ?float $priceHt;

    #[Optional]
    public ?string $reference;

    #[Optional]
    public ?string $sku;

    #[Optional]
    public ?Stock $stock;

    #[Optional('tva_rate')]
    public ?float $tvaRate;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Stock|StockShape|null $stock
     */
    public static function with(
        ?float $buyingPrice = null,
        ?string $name = null,
        mixed $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        Stock|array|null $stock = null,
        ?float $tvaRate = null,
    ): self {
        $self = new self;

        null !== $buyingPrice && $self['buyingPrice'] = $buyingPrice;
        null !== $name && $self['name'] = $name;
        null !== $options && $self['options'] = $options;
        null !== $priceHt && $self['priceHt'] = $priceHt;
        null !== $reference && $self['reference'] = $reference;
        null !== $sku && $self['sku'] = $sku;
        null !== $stock && $self['stock'] = $stock;
        null !== $tvaRate && $self['tvaRate'] = $tvaRate;

        return $self;
    }

    public function withBuyingPrice(float $buyingPrice): self
    {
        $self = clone $this;
        $self['buyingPrice'] = $buyingPrice;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withOptions(mixed $options): self
    {
        $self = clone $this;
        $self['options'] = $options;

        return $self;
    }

    public function withPriceHt(float $priceHt): self
    {
        $self = clone $this;
        $self['priceHt'] = $priceHt;

        return $self;
    }

    public function withReference(string $reference): self
    {
        $self = clone $this;
        $self['reference'] = $reference;

        return $self;
    }

    public function withSKU(string $sku): self
    {
        $self = clone $this;
        $self['sku'] = $sku;

        return $self;
    }

    /**
     * @param Stock|StockShape $stock
     */
    public function withStock(Stock|array $stock): self
    {
        $self = clone $this;
        $self['stock'] = $stock;

        return $self;
    }

    public function withTvaRate(float $tvaRate): self
    {
        $self = clone $this;
        $self['tvaRate'] = $tvaRate;

        return $self;
    }
}
