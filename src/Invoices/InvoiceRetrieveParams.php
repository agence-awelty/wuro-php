<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les détails complets d'une facture spécifique.
 *
 * Inclut toutes les informations: client, lignes, paiements, etc.
 *
 * @see Wuro\Services\InvoicesService::retrieve()
 *
 * @phpstan-type InvoiceRetrieveParamsShape = array{populate?: string|null}
 */
final class InvoiceRetrieveParams implements BaseModel
{
    /** @use SdkModel<InvoiceRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Champs à peupler (ex. "client,positionCreator").
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
     * Champs à peupler (ex. "client,positionCreator").
     */
    public function withPopulate(string $populate): self
    {
        $self = clone $this;
        $self['populate'] = $populate;

        return $self;
    }
}
