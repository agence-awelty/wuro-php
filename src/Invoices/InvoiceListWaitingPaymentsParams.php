<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceListWaitingPaymentsParams\State;

/**
 * Récupère les factures qui sont en attente de paiement (état waiting ou late).
 *
 * **Réponse:**
 * - `invoices`: Liste des factures en attente
 * - `total`: Nombre de factures
 * - `totalAmount`: Somme des montants restant à payer (total_nettopay)
 *
 * @see Wuro\Services\InvoicesService::listWaitingPayments()
 *
 * @phpstan-type InvoiceListWaitingPaymentsParamsShape = array{
 *   limit?: int|null, skip?: int|null, state?: list<State|value-of<State>>|null
 * }
 */
final class InvoiceListWaitingPaymentsParams implements BaseModel
{
    /** @use SdkModel<InvoiceListWaitingPaymentsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?int $limit;

    #[Optional]
    public ?int $skip;

    /**
     * Filtre par état (par défaut waiting et late).
     *
     * @var list<value-of<State>>|null $state
     */
    #[Optional(list: State::class)]
    public ?array $state;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<State|value-of<State>>|null $state
     */
    public static function with(
        ?int $limit = null,
        ?int $skip = null,
        ?array $state = null
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Filtre par état (par défaut waiting et late).
     *
     * @param list<State|value-of<State>> $state
     */
    public function withState(array $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
