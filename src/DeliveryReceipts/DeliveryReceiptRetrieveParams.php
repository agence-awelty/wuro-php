<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les informations détaillées d'un bon de livraison par son identifiant.
 *
 * Les informations retournées incluent :
 * - Les informations client (nom, adresse, email, etc.)
 * - Les lignes du bon (produits, quantités, poids)
 * - L'état actuel du bon (brouillon, en attente, expédié, livré, etc.)
 * - Les dates importantes (création, expédition)
 * - Les liens vers le PDF et la version HTML
 *
 * @see Wuro\Services\DeliveryReceiptsService::retrieve()
 *
 * @phpstan-type DeliveryReceiptRetrieveParamsShape = array{populate?: string|null}
 */
final class DeliveryReceiptRetrieveParams implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Relations à inclure (ex. "client", "documentModel").
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
     * Relations à inclure (ex. "client", "documentModel").
     */
    public function withPopulate(string $populate): self
    {
        $self = clone $this;
        $self['populate'] = $populate;

        return $self;
    }
}
