<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ProductShape from \Wuro\Products\Product
 *
 * @phpstan-type ProductUpdateResponseShape = array{
 *   updatedProduct?: null|Product|ProductShape
 * }
 */
final class ProductUpdateResponse implements BaseModel
{
    /** @use SdkModel<ProductUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Product $updatedProduct;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Product|ProductShape|null $updatedProduct
     */
    public static function with(Product|array|null $updatedProduct = null): self
    {
        $self = new self;

        null !== $updatedProduct && $self['updatedProduct'] = $updatedProduct;

        return $self;
    }

    /**
     * @param Product|ProductShape $updatedProduct
     */
    public function withUpdatedProduct(Product|array $updatedProduct): self
    {
        $self = clone $this;
        $self['updatedProduct'] = $updatedProduct;

        return $self;
    }
}
