<?php

declare(strict_types=1);

namespace Wuro\Products\Variant;

use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Supprime une variante de produit.
 *
 * **Attention:**
 * - Cette opération est irréversible
 * - La variante ne sera plus disponible à la vente
 *
 * **Événement déclenché:** DELETE_PRODUCT_VARIANT
 *
 * @see Wuro\Services\Products\VariantService::delete()
 *
 * @phpstan-type VariantDeleteParamsShape = array{productID: string}
 */
final class VariantDeleteParams implements BaseModel
{
    /** @use SdkModel<VariantDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $productID;

    /**
     * `new VariantDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VariantDeleteParams::with(productID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VariantDeleteParams)->withProductID(...)
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
     */
    public static function with(string $productID): self
    {
        $self = new self;

        $self['productID'] = $productID;

        return $self;
    }

    public function withProductID(string $productID): self
    {
        $self = clone $this;
        $self['productID'] = $productID;

        return $self;
    }
}
