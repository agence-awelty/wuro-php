<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les informations détaillées d'un produit par son identifiant.
 *
 * Les informations incluent :
 * - Informations de base (nom, référence, description)
 * - Prix et TVA
 * - Unités de vente et conditionnement
 * - Catégorie(s) associée(s)
 * - Variantes si existantes
 *
 * @see Wuro\Services\ProductsService::retrieve()
 *
 * @phpstan-type ProductRetrieveParamsShape = array{populate?: string|null}
 */
final class ProductRetrieveParams implements BaseModel
{
    /** @use SdkModel<ProductRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Relations à inclure (ex. "category", "variants").
     */
    #[Optional]
    public ?string $populate;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $populate = null): self
    {
        $self = new self;

        null !== $populate && $self['populate'] = $populate;

        return $self;
    }

    /**
     * Relations à inclure (ex. "category", "variants").
     */
    public function withPopulate(string $populate): self
    {
        $self = clone $this;
        $self['populate'] = $populate;

        return $self;
    }
}
