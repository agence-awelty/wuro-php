<?php

declare(strict_types=1);

namespace Wuro\Products\Variant;

use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les détails d'une variante de produit spécifique.
 *
 * @see Wuro\Services\Products\VariantService::retrieve()
 *
 * @phpstan-type VariantRetrieveParamsShape = array{productID: string}
 */
final class VariantRetrieveParams implements BaseModel
{
    /** @use SdkModel<VariantRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $productID;

    /**
     * `new VariantRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VariantRetrieveParams::with(productID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VariantRetrieveParams)->withProductID(...)
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
