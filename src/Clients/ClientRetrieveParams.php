<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les informations détaillées d'un client par son identifiant.
 *
 * Les informations incluent :
 * - Coordonnées (nom, adresse, email, téléphone)
 * - Informations fiscales (SIRET, TVA intracommunautaire)
 * - Conditions commerciales (remise par défaut, délai de paiement)
 * - Statistiques (CA, nombre de factures, etc.)
 *
 * @see Wuro\Services\ClientsService::retrieve()
 *
 * @phpstan-type ClientRetrieveParamsShape = array{populate?: string|null}
 */
final class ClientRetrieveParams implements BaseModel
{
    /** @use SdkModel<ClientRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Relations à inclure.
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
     * Relations à inclure.
     */
    public function withPopulate(string $populate): self
    {
        $self = clone $this;
        $self['populate'] = $populate;

        return $self;
    }
}
