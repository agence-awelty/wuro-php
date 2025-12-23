<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceListParams\State;
use Wuro\Invoices\InvoiceListParams\Type;

/**
 * Récupère la liste des factures avec pagination, tri et filtres avancés.
 *
 * **Filtres disponibles:**
 * - `state`: État de la facture (draft, waiting, paid, notpaid, late, inactive)
 * - `type`: Type de facture (invoice, invoice_credit, external, external_credit, proforma, advance)
 * - `client`: ID du client
 * - `minDate` / `maxDate`: Plage de dates
 * - `number`: Numéro de facture
 * - `search`: Recherche textuelle
 *
 * **Réponse:**
 * - `invoices`: Liste des factures
 * - `total`: Nombre total de factures correspondantes
 * - `skip` et `limit`: Paramètres de pagination
 *
 * @see Wuro\Services\InvoicesService::list()
 *
 * @phpstan-type InvoiceListParamsShape = array{
 *   client?: string|null,
 *   limit?: int|null,
 *   maxDate?: \DateTimeInterface|null,
 *   minDate?: \DateTimeInterface|null,
 *   number?: string|null,
 *   search?: string|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class InvoiceListParams implements BaseModel
{
    /** @use SdkModel<InvoiceListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filtre par ID du client.
     */
    #[Optional]
    public ?string $client;

    /**
     * Nombre maximum de factures à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Date maximum (ISO 8601).
     */
    #[Optional]
    public ?\DateTimeInterface $maxDate;

    /**
     * Date minimum (ISO 8601).
     */
    #[Optional]
    public ?\DateTimeInterface $minDate;

    /**
     * Numéro de facture (recherche exacte).
     */
    #[Optional]
    public ?string $number;

    /**
     * Recherche textuelle dans les factures.
     */
    #[Optional]
    public ?string $search;

    /**
     * Nombre de factures à ignorer (pagination).
     */
    #[Optional]
    public ?int $skip;

    /**
     * Champ de tri et direction (ex. "date:-1" pour tri décroissant par date).
     */
    #[Optional]
    public ?string $sort;

    /**
     * Filtre par état de la facture.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Filtre par type de facture.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $client = null,
        ?int $limit = null,
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $number = null,
        ?string $search = null,
        ?int $skip = null,
        ?string $sort = null,
        State|string|null $state = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $client && $self['client'] = $client;
        null !== $limit && $self['limit'] = $limit;
        null !== $maxDate && $self['maxDate'] = $maxDate;
        null !== $minDate && $self['minDate'] = $minDate;
        null !== $number && $self['number'] = $number;
        null !== $search && $self['search'] = $search;
        null !== $skip && $self['skip'] = $skip;
        null !== $sort && $self['sort'] = $sort;
        null !== $state && $self['state'] = $state;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Filtre par ID du client.
     */
    public function withClient(string $client): self
    {
        $self = clone $this;
        $self['client'] = $client;

        return $self;
    }

    /**
     * Nombre maximum de factures à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Date maximum (ISO 8601).
     */
    public function withMaxDate(\DateTimeInterface $maxDate): self
    {
        $self = clone $this;
        $self['maxDate'] = $maxDate;

        return $self;
    }

    /**
     * Date minimum (ISO 8601).
     */
    public function withMinDate(\DateTimeInterface $minDate): self
    {
        $self = clone $this;
        $self['minDate'] = $minDate;

        return $self;
    }

    /**
     * Numéro de facture (recherche exacte).
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * Recherche textuelle dans les factures.
     */
    public function withSearch(string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Nombre de factures à ignorer (pagination).
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Champ de tri et direction (ex. "date:-1" pour tri décroissant par date).
     */
    public function withSort(string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Filtre par état de la facture.
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * Filtre par type de facture.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
