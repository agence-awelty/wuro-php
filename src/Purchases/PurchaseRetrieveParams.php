<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les informations détaillées d'un achat par son identifiant.
 *
 * Les informations incluent :
 * - Informations du fournisseur
 * - Lignes de l'achat (produits/services, quantités, prix)
 * - Montants (HT, TVA, TTC)
 * - État et échéances de paiement
 *
 * @see Wuro\Services\PurchasesService::retrieve()
 *
 * @phpstan-type PurchaseRetrieveParamsShape = array{populate?: string|null}
 */
final class PurchaseRetrieveParams implements BaseModel
{
    /** @use SdkModel<PurchaseRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Relations à inclure (ex. "supplier").
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
     * Relations à inclure (ex. "supplier").
     */
    public function withPopulate(string $populate): self
    {
        $self = clone $this;
        $self['populate'] = $populate;

        return $self;
    }
}
