<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ProductShape from \Wuro\Products\Product
 *
 * @phpstan-type ProductNewResponseShape = array{
 *   newProduct?: null|Product|ProductShape
 * }
 */
final class ProductNewResponse implements BaseModel
{
    /** @use SdkModel<ProductNewResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Product $newProduct;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Product|ProductShape|null $newProduct
     */
    public static function with(Product|array|null $newProduct = null): self
    {
        $self = new self;

        null !== $newProduct && $self['newProduct'] = $newProduct;

        return $self;
    }

    /**
     * @param Product|ProductShape $newProduct
     */
    public function withNewProduct(Product|array $newProduct): self
    {
        $self = clone $this;
        $self['newProduct'] = $newProduct;

        return $self;
    }
}
