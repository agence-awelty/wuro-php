<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ProductShape from \Wuro\Products\Product
 *
 * @phpstan-type ProductDeleteResponseShape = array{
 *   product?: null|Product|ProductShape
 * }
 */
final class ProductDeleteResponse implements BaseModel
{
    /** @use SdkModel<ProductDeleteResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Product $product;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Product|ProductShape|null $product
     */
    public static function with(Product|array|null $product = null): self
    {
        $self = new self;

        null !== $product && $self['product'] = $product;

        return $self;
    }

    /**
     * @param Product|ProductShape $product
     */
    public function withProduct(Product|array $product): self
    {
        $self = clone $this;
        $self['product'] = $product;

        return $self;
    }
}
