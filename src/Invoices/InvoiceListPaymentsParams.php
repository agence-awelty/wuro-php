<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère la liste des paiements enregistrés sur les factures.
 *
 * **Filtres spécifiques aux paiements:**
 * - `minDate` / `maxDate` / `date`: Date du paiement
 * - `amount`: Montant du paiement
 * - `method_name`: Nom du mode de paiement
 * - `mode`: ID du mode de paiement
 *
 * **Réponse agrégée:**
 * - `payments`: Liste des paiements avec informations de la facture associée
 * - `count`: Nombre total de paiements
 * - `total`: Somme des montants
 * - `average`: Moyenne des montants
 *
 * @see Wuro\Services\InvoicesService::listPayments()
 *
 * @phpstan-type InvoiceListPaymentsParamsShape = array{
 *   limit?: int|null,
 *   maxDate?: \DateTimeInterface|null,
 *   minDate?: \DateTimeInterface|null,
 *   mode?: string|null,
 *   skip?: int|null,
 * }
 */
final class InvoiceListPaymentsParams implements BaseModel
{
    /** @use SdkModel<InvoiceListPaymentsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?int $limit;

    /**
     * Date maximum du paiement.
     */
    #[Optional]
    public ?\DateTimeInterface $maxDate;

    /**
     * Date minimum du paiement.
     */
    #[Optional]
    public ?\DateTimeInterface $minDate;

    /**
     * ID du mode de paiement.
     */
    #[Optional]
    public ?string $mode;

    #[Optional]
    public ?int $skip;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?int $limit = null,
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $mode = null,
        ?int $skip = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $maxDate && $self['maxDate'] = $maxDate;
        null !== $minDate && $self['minDate'] = $minDate;
        null !== $mode && $self['mode'] = $mode;
        null !== $skip && $self['skip'] = $skip;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Date maximum du paiement.
     */
    public function withMaxDate(\DateTimeInterface $maxDate): self
    {
        $self = clone $this;
        $self['maxDate'] = $maxDate;

        return $self;
    }

    /**
     * Date minimum du paiement.
     */
    public function withMinDate(\DateTimeInterface $minDate): self
    {
        $self = clone $this;
        $self['minDate'] = $minDate;

        return $self;
    }

    /**
     * ID du mode de paiement.
     */
    public function withMode(string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }
}
