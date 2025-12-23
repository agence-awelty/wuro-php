<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Products\Product\File;
use Wuro\Products\Product\Image;
use Wuro\Products\Product\Option;
use Wuro\Products\Product\Specifications;
use Wuro\Products\Product\State;
use Wuro\Products\Product\Stock;

/**
 * @phpstan-import-type FileShape from \Wuro\Products\Product\File
 * @phpstan-import-type ImageShape from \Wuro\Products\Product\Image
 * @phpstan-import-type OptionShape from \Wuro\Products\Product\Option
 * @phpstan-import-type SpecificationsShape from \Wuro\Products\Product\Specifications
 * @phpstan-import-type StockShape from \Wuro\Products\Product\Stock
 *
 * @phpstan-type ProductShape = array{
 *   _id?: string|null,
 *   analyticalCode?: string|null,
 *   buyingPrice?: float|null,
 *   category?: string|null,
 *   commercialMargin?: float|null,
 *   company?: string|null,
 *   costPrice?: float|null,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   ecotax?: float|null,
 *   electronic?: bool|null,
 *   files?: list<FileShape>|null,
 *   grossMargin?: float|null,
 *   hasSpecifications?: bool|null,
 *   hasStockManagement?: bool|null,
 *   hasVariations?: bool|null,
 *   images?: list<ImageShape>|null,
 *   isMarchandise?: bool|null,
 *   mandatoryMentions?: string|null,
 *   name?: string|null,
 *   options?: list<OptionShape>|null,
 *   priceHt?: float|null,
 *   reference?: string|null,
 *   sku?: string|null,
 *   specifications?: null|Specifications|SpecificationsShape,
 *   state?: null|State|value-of<State>,
 *   stock?: null|Stock|StockShape,
 *   suppliers?: list<string>|null,
 *   tva?: string|null,
 *   tvaRate?: float|null,
 *   unit?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   urlExt?: string|null,
 *   variants?: list<string>|null,
 * }
 */
final class Product implements BaseModel
{
    /** @use SdkModel<ProductShape> */
    use SdkModel;

    /**
     * Unique identifier for the product.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Analytical code.
     */
    #[Optional('analytical_code')]
    public ?string $analyticalCode;

    /**
     * Buying/cost price.
     */
    #[Optional('buying_price')]
    public ?float $buyingPrice;

    /**
     * Reference to product category.
     */
    #[Optional]
    public ?string $category;

    /**
     * Commercial margin (price_ht - buying_price).
     */
    #[Optional('commercial_margin')]
    public ?float $commercialMargin;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Cost price (coût de revient).
     */
    #[Optional('cost_price')]
    public ?float $costPrice;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Product description.
     */
    #[Optional]
    public ?string $description;

    /**
     * Ecotax amount.
     */
    #[Optional]
    public ?float $ecotax;

    /**
     * Is electronic product.
     */
    #[Optional]
    public ?bool $electronic;

    /** @var list<File>|null $files */
    #[Optional(list: File::class)]
    public ?array $files;

    /**
     * Gross margin (price_ht - cost_price).
     */
    #[Optional('gross_margin')]
    public ?float $grossMargin;

    /**
     * Has specifications.
     */
    #[Optional]
    public ?bool $hasSpecifications;

    /**
     * Stock management enabled.
     */
    #[Optional]
    public ?bool $hasStockManagement;

    /**
     * Has product variations.
     */
    #[Optional]
    public ?bool $hasVariations;

    /** @var list<Image>|null $images */
    #[Optional(list: Image::class)]
    public ?array $images;

    /**
     * Is merchandise.
     */
    #[Optional('is_marchandise')]
    public ?bool $isMarchandise;

    /**
     * Mandatory legal mentions.
     */
    #[Optional('mandatory_mentions')]
    public ?string $mandatoryMentions;

    /**
     * Product name (required).
     */
    #[Optional]
    public ?string $name;

    /** @var list<Option>|null $options */
    #[Optional(list: Option::class)]
    public ?array $options;

    /**
     * Price without tax.
     */
    #[Optional('price_ht')]
    public ?float $priceHt;

    /**
     * Product reference.
     */
    #[Optional]
    public ?string $reference;

    /**
     * Stock Keeping Unit.
     */
    #[Optional]
    public ?string $sku;

    #[Optional]
    public ?Specifications $specifications;

    /** @var value-of<State>|null $state */
    #[Optional(enum: State::class)]
    public ?string $state;

    #[Optional]
    public ?Stock $stock;

    /**
     * List of supplier (client) references.
     *
     * @var list<string>|null $suppliers
     */
    #[Optional(list: 'string')]
    public ?array $suppliers;

    /**
     * Reference to VAT rate.
     */
    #[Optional]
    public ?string $tva;

    /**
     * VAT rate value.
     */
    #[Optional('tva_rate')]
    public ?float $tvaRate;

    /**
     * Unit of measurement.
     */
    #[Optional]
    public ?string $unit;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * External URL.
     */
    #[Optional('url_ext')]
    public ?string $urlExt;

    /**
     * List of variant references.
     *
     * @var list<string>|null $variants
     */
    #[Optional(list: 'string')]
    public ?array $variants;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<FileShape>|null $files
     * @param list<ImageShape>|null $images
     * @param list<OptionShape>|null $options
     * @param Specifications|SpecificationsShape|null $specifications
     * @param State|value-of<State>|null $state
     * @param Stock|StockShape|null $stock
     * @param list<string>|null $suppliers
     * @param list<string>|null $variants
     */
    public static function with(
        ?string $_id = null,
        ?string $analyticalCode = null,
        ?float $buyingPrice = null,
        ?string $category = null,
        ?float $commercialMargin = null,
        ?string $company = null,
        ?float $costPrice = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?float $ecotax = null,
        ?bool $electronic = null,
        ?array $files = null,
        ?float $grossMargin = null,
        ?bool $hasSpecifications = null,
        ?bool $hasStockManagement = null,
        ?bool $hasVariations = null,
        ?array $images = null,
        ?bool $isMarchandise = null,
        ?string $mandatoryMentions = null,
        ?string $name = null,
        ?array $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        Specifications|array|null $specifications = null,
        State|string|null $state = null,
        Stock|array|null $stock = null,
        ?array $suppliers = null,
        ?string $tva = null,
        ?float $tvaRate = null,
        ?string $unit = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $urlExt = null,
        ?array $variants = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $analyticalCode && $self['analyticalCode'] = $analyticalCode;
        null !== $buyingPrice && $self['buyingPrice'] = $buyingPrice;
        null !== $category && $self['category'] = $category;
        null !== $commercialMargin && $self['commercialMargin'] = $commercialMargin;
        null !== $company && $self['company'] = $company;
        null !== $costPrice && $self['costPrice'] = $costPrice;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $ecotax && $self['ecotax'] = $ecotax;
        null !== $electronic && $self['electronic'] = $electronic;
        null !== $files && $self['files'] = $files;
        null !== $grossMargin && $self['grossMargin'] = $grossMargin;
        null !== $hasSpecifications && $self['hasSpecifications'] = $hasSpecifications;
        null !== $hasStockManagement && $self['hasStockManagement'] = $hasStockManagement;
        null !== $hasVariations && $self['hasVariations'] = $hasVariations;
        null !== $images && $self['images'] = $images;
        null !== $isMarchandise && $self['isMarchandise'] = $isMarchandise;
        null !== $mandatoryMentions && $self['mandatoryMentions'] = $mandatoryMentions;
        null !== $name && $self['name'] = $name;
        null !== $options && $self['options'] = $options;
        null !== $priceHt && $self['priceHt'] = $priceHt;
        null !== $reference && $self['reference'] = $reference;
        null !== $sku && $self['sku'] = $sku;
        null !== $specifications && $self['specifications'] = $specifications;
        null !== $state && $self['state'] = $state;
        null !== $stock && $self['stock'] = $stock;
        null !== $suppliers && $self['suppliers'] = $suppliers;
        null !== $tva && $self['tva'] = $tva;
        null !== $tvaRate && $self['tvaRate'] = $tvaRate;
        null !== $unit && $self['unit'] = $unit;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $urlExt && $self['urlExt'] = $urlExt;
        null !== $variants && $self['variants'] = $variants;

        return $self;
    }

    /**
     * Unique identifier for the product.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Analytical code.
     */
    public function withAnalyticalCode(string $analyticalCode): self
    {
        $self = clone $this;
        $self['analyticalCode'] = $analyticalCode;

        return $self;
    }

    /**
     * Buying/cost price.
     */
    public function withBuyingPrice(float $buyingPrice): self
    {
        $self = clone $this;
        $self['buyingPrice'] = $buyingPrice;

        return $self;
    }

    /**
     * Reference to product category.
     */
    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Commercial margin (price_ht - buying_price).
     */
    public function withCommercialMargin(float $commercialMargin): self
    {
        $self = clone $this;
        $self['commercialMargin'] = $commercialMargin;

        return $self;
    }

    /**
     * Reference to the company.
     */
    public function withCompany(string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    /**
     * Cost price (coût de revient).
     */
    public function withCostPrice(float $costPrice): self
    {
        $self = clone $this;
        $self['costPrice'] = $costPrice;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Product description.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Ecotax amount.
     */
    public function withEcotax(float $ecotax): self
    {
        $self = clone $this;
        $self['ecotax'] = $ecotax;

        return $self;
    }

    /**
     * Is electronic product.
     */
    public function withElectronic(bool $electronic): self
    {
        $self = clone $this;
        $self['electronic'] = $electronic;

        return $self;
    }

    /**
     * @param list<FileShape> $files
     */
    public function withFiles(array $files): self
    {
        $self = clone $this;
        $self['files'] = $files;

        return $self;
    }

    /**
     * Gross margin (price_ht - cost_price).
     */
    public function withGrossMargin(float $grossMargin): self
    {
        $self = clone $this;
        $self['grossMargin'] = $grossMargin;

        return $self;
    }

    /**
     * Has specifications.
     */
    public function withHasSpecifications(bool $hasSpecifications): self
    {
        $self = clone $this;
        $self['hasSpecifications'] = $hasSpecifications;

        return $self;
    }

    /**
     * Stock management enabled.
     */
    public function withHasStockManagement(bool $hasStockManagement): self
    {
        $self = clone $this;
        $self['hasStockManagement'] = $hasStockManagement;

        return $self;
    }

    /**
     * Has product variations.
     */
    public function withHasVariations(bool $hasVariations): self
    {
        $self = clone $this;
        $self['hasVariations'] = $hasVariations;

        return $self;
    }

    /**
     * @param list<ImageShape> $images
     */
    public function withImages(array $images): self
    {
        $self = clone $this;
        $self['images'] = $images;

        return $self;
    }

    /**
     * Is merchandise.
     */
    public function withIsMarchandise(bool $isMarchandise): self
    {
        $self = clone $this;
        $self['isMarchandise'] = $isMarchandise;

        return $self;
    }

    /**
     * Mandatory legal mentions.
     */
    public function withMandatoryMentions(string $mandatoryMentions): self
    {
        $self = clone $this;
        $self['mandatoryMentions'] = $mandatoryMentions;

        return $self;
    }

    /**
     * Product name (required).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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

    /**
     * Price without tax.
     */
    public function withPriceHt(float $priceHt): self
    {
        $self = clone $this;
        $self['priceHt'] = $priceHt;

        return $self;
    }

    /**
     * Product reference.
     */
    public function withReference(string $reference): self
    {
        $self = clone $this;
        $self['reference'] = $reference;

        return $self;
    }

    /**
     * Stock Keeping Unit.
     */
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
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

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
     * List of supplier (client) references.
     *
     * @param list<string> $suppliers
     */
    public function withSuppliers(array $suppliers): self
    {
        $self = clone $this;
        $self['suppliers'] = $suppliers;

        return $self;
    }

    /**
     * Reference to VAT rate.
     */
    public function withTva(string $tva): self
    {
        $self = clone $this;
        $self['tva'] = $tva;

        return $self;
    }

    /**
     * VAT rate value.
     */
    public function withTvaRate(float $tvaRate): self
    {
        $self = clone $this;
        $self['tvaRate'] = $tvaRate;

        return $self;
    }

    /**
     * Unit of measurement.
     */
    public function withUnit(string $unit): self
    {
        $self = clone $this;
        $self['unit'] = $unit;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * External URL.
     */
    public function withURLExt(string $urlExt): self
    {
        $self = clone $this;
        $self['urlExt'] = $urlExt;

        return $self;
    }

    /**
     * List of variant references.
     *
     * @param list<string> $variants
     */
    public function withVariants(array $variants): self
    {
        $self = clone $this;
        $self['variants'] = $variants;

        return $self;
    }
}
