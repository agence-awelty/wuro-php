<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ProductShape from \Wuro\Products\Product
 *
 * @phpstan-type ProductListResponseShape = array{
 *   limit?: int|null,
 *   products?: list<ProductShape>|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class ProductListResponse implements BaseModel
{
    /** @use SdkModel<ProductListResponseShape> */
    use SdkModel;

    /**
     * Limite utilisée.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Tableau des produits.
     *
     * @var list<Product>|null $products
     */
    #[Optional(list: Product::class)]
    public ?array $products;

    /**
     * Offset utilisé.
     */
    #[Optional]
    public ?int $skip;

    /**
     * Nombre total de produits.
     */
    #[Optional]
    public ?int $total;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ProductShape>|null $products
     */
    public static function with(
        ?int $limit = null,
        ?array $products = null,
        ?int $skip = null,
        ?int $total = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $products && $self['products'] = $products;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Limite utilisée.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Tableau des produits.
     *
     * @param list<ProductShape> $products
     */
    public function withProducts(array $products): self
    {
        $self = clone $this;
        $self['products'] = $products;

        return $self;
    }

    /**
     * Offset utilisé.
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Nombre total de produits.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
