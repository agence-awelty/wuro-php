<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Products\ProductUpdateParams\Option;
use Wuro\Products\ProductUpdateParams\Specifications;
use Wuro\Products\ProductUpdateParams\Stock;

/**
 * Met à jour les informations d'un produit existant.
 *
 * Vous pouvez modifier :
 * - Les informations de base (nom, référence, description)
 * - Les prix et TVA
 * - Les unités de vente
 * - Les catégories
 *
 * ## Événement déclenché
 *
 * Un événement `UPDATE_PRODUCT` est émis après la mise à jour.
 *
 * @see Wuro\Services\ProductsService::update()
 *
 * @phpstan-import-type OptionShape from \Wuro\Products\ProductUpdateParams\Option
 * @phpstan-import-type SpecificationsShape from \Wuro\Products\ProductUpdateParams\Specifications
 * @phpstan-import-type StockShape from \Wuro\Products\ProductUpdateParams\Stock
 *
 * @phpstan-type ProductUpdateParamsShape = array{
 *   name: string,
 *   analyticalCode?: string|null,
 *   buyingPrice?: float|null,
 *   category?: string|null,
 *   costPrice?: float|null,
 *   description?: string|null,
 *   ecotax?: float|null,
 *   electronic?: bool|null,
 *   hasSpecifications?: bool|null,
 *   hasStockManagement?: bool|null,
 *   hasVariations?: bool|null,
 *   isMarchandise?: bool|null,
 *   mandatoryMentions?: string|null,
 *   options?: list<OptionShape>|null,
 *   priceHt?: float|null,
 *   reference?: string|null,
 *   sku?: string|null,
 *   specifications?: null|Specifications|SpecificationsShape,
 *   stock?: null|Stock|StockShape,
 *   suppliers?: list<string>|null,
 *   tva?: string|null,
 *   tvaRate?: float|null,
 *   unit?: string|null,
 *   urlExt?: string|null,
 * }
 */
final class ProductUpdateParams implements BaseModel
{
    /** @use SdkModel<ProductUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $name;

    #[Optional('analytical_code')]
    public ?string $analyticalCode;

    #[Optional('buying_price')]
    public ?float $buyingPrice;

    #[Optional]
    public ?string $category;

    #[Optional('cost_price')]
    public ?float $costPrice;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?float $ecotax;

    #[Optional]
    public ?bool $electronic;

    #[Optional]
    public ?bool $hasSpecifications;

    #[Optional]
    public ?bool $hasStockManagement;

    #[Optional]
    public ?bool $hasVariations;

    #[Optional('is_marchandise')]
    public ?bool $isMarchandise;

    #[Optional('mandatory_mentions')]
    public ?string $mandatoryMentions;

    /** @var list<Option>|null $options */
    #[Optional(list: Option::class)]
    public ?array $options;

    #[Optional('price_ht')]
    public ?float $priceHt;

    #[Optional]
    public ?string $reference;

    #[Optional]
    public ?string $sku;

    #[Optional]
    public ?Specifications $specifications;

    #[Optional]
    public ?Stock $stock;

    /** @var list<string>|null $suppliers */
    #[Optional(list: 'string')]
    public ?array $suppliers;

    #[Optional]
    public ?string $tva;

    #[Optional('tva_rate')]
    public ?float $tvaRate;

    #[Optional]
    public ?string $unit;

    #[Optional('url_ext')]
    public ?string $urlExt;

    /**
     * `new ProductUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProductUpdateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProductUpdateParams)->withName(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<OptionShape>|null $options
     * @param Specifications|SpecificationsShape|null $specifications
     * @param Stock|StockShape|null $stock
     * @param list<string>|null $suppliers
     */
    public static function with(
        string $name,
        ?string $analyticalCode = null,
        ?float $buyingPrice = null,
        ?string $category = null,
        ?float $costPrice = null,
        ?string $description = null,
        ?float $ecotax = null,
        ?bool $electronic = null,
        ?bool $hasSpecifications = null,
        ?bool $hasStockManagement = null,
        ?bool $hasVariations = null,
        ?bool $isMarchandise = null,
        ?string $mandatoryMentions = null,
        ?array $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        Specifications|array|null $specifications = null,
        Stock|array|null $stock = null,
        ?array $suppliers = null,
        ?string $tva = null,
        ?float $tvaRate = null,
        ?string $unit = null,
        ?string $urlExt = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $analyticalCode && $self['analyticalCode'] = $analyticalCode;
        null !== $buyingPrice && $self['buyingPrice'] = $buyingPrice;
        null !== $category && $self['category'] = $category;
        null !== $costPrice && $self['costPrice'] = $costPrice;
        null !== $description && $self['description'] = $description;
        null !== $ecotax && $self['ecotax'] = $ecotax;
        null !== $electronic && $self['electronic'] = $electronic;
        null !== $hasSpecifications && $self['hasSpecifications'] = $hasSpecifications;
        null !== $hasStockManagement && $self['hasStockManagement'] = $hasStockManagement;
        null !== $hasVariations && $self['hasVariations'] = $hasVariations;
        null !== $isMarchandise && $self['isMarchandise'] = $isMarchandise;
        null !== $mandatoryMentions && $self['mandatoryMentions'] = $mandatoryMentions;
        null !== $options && $self['options'] = $options;
        null !== $priceHt && $self['priceHt'] = $priceHt;
        null !== $reference && $self['reference'] = $reference;
        null !== $sku && $self['sku'] = $sku;
        null !== $specifications && $self['specifications'] = $specifications;
        null !== $stock && $self['stock'] = $stock;
        null !== $suppliers && $self['suppliers'] = $suppliers;
        null !== $tva && $self['tva'] = $tva;
        null !== $tvaRate && $self['tvaRate'] = $tvaRate;
        null !== $unit && $self['unit'] = $unit;
        null !== $urlExt && $self['urlExt'] = $urlExt;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withAnalyticalCode(string $analyticalCode): self
    {
        $self = clone $this;
        $self['analyticalCode'] = $analyticalCode;

        return $self;
    }

    public function withBuyingPrice(float $buyingPrice): self
    {
        $self = clone $this;
        $self['buyingPrice'] = $buyingPrice;

        return $self;
    }

    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    public function withCostPrice(float $costPrice): self
    {
        $self = clone $this;
        $self['costPrice'] = $costPrice;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withEcotax(float $ecotax): self
    {
        $self = clone $this;
        $self['ecotax'] = $ecotax;

        return $self;
    }

    public function withElectronic(bool $electronic): self
    {
        $self = clone $this;
        $self['electronic'] = $electronic;

        return $self;
    }

    public function withHasSpecifications(bool $hasSpecifications): self
    {
        $self = clone $this;
        $self['hasSpecifications'] = $hasSpecifications;

        return $self;
    }

    public function withHasStockManagement(bool $hasStockManagement): self
    {
        $self = clone $this;
        $self['hasStockManagement'] = $hasStockManagement;

        return $self;
    }

    public function withHasVariations(bool $hasVariations): self
    {
        $self = clone $this;
        $self['hasVariations'] = $hasVariations;

        return $self;
    }

    public function withIsMarchandise(bool $isMarchandise): self
    {
        $self = clone $this;
        $self['isMarchandise'] = $isMarchandise;

        return $self;
    }

    public function withMandatoryMentions(string $mandatoryMentions): self
    {
        $self = clone $this;
        $self['mandatoryMentions'] = $mandatoryMentions;

        return $self;
    }

    /**
     * @param list<OptionShape> $options
     */
    public function withOptions(array $options): self
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
     * @param Specifications|SpecificationsShape $specifications
     */
    public function withSpecifications(
        Specifications|array $specifications
    ): self {
        $self = clone $this;
        $self['specifications'] = $specifications;

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

    /**
     * @param list<string> $suppliers
     */
    public function withSuppliers(array $suppliers): self
    {
        $self = clone $this;
        $self['suppliers'] = $suppliers;

        return $self;
    }

    public function withTva(string $tva): self
    {
        $self = clone $this;
        $self['tva'] = $tva;

        return $self;
    }

    public function withTvaRate(float $tvaRate): self
    {
        $self = clone $this;
        $self['tvaRate'] = $tvaRate;

        return $self;
    }

    public function withUnit(string $unit): self
    {
        $self = clone $this;
        $self['unit'] = $unit;

        return $self;
    }

    public function withURLExt(string $urlExt): self
    {
        $self = clone $this;
        $self['urlExt'] = $urlExt;

        return $self;
    }
}
