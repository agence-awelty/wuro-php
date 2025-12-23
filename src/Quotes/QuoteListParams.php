<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Quotes\QuoteListParams\State;
use Wuro\Quotes\QuoteListParams\Type;

/**
 * Récupère la liste des devis avec pagination, tri et filtres.
 *
 * **Filtres disponibles:**
 * - `state`: État du devis (draft, pending, waiting, accepted, refused, invoiced, canceled, inactive)
 * - `type`: Type de document (quote, proforma, bdc)
 * - `client`: ID du client
 * - `minDate` / `maxDate`: Plage de dates
 * - `number`: Numéro du devis
 * - `search`: Recherche textuelle
 *
 * **Réponse:**
 * - `quotes`: Liste des devis
 * - `total`: Nombre total de devis correspondants
 * - `skip` et `limit`: Paramètres de pagination
 *
 * @see Wuro\Services\QuotesService::list()
 *
 * @phpstan-type QuoteListParamsShape = array{
 *   client?: string|null,
 *   limit?: int|null,
 *   maxDate?: \DateTimeInterface|null,
 *   minDate?: \DateTimeInterface|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class QuoteListParams implements BaseModel
{
    /** @use SdkModel<QuoteListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filtre par ID du client.
     */
    #[Optional]
    public ?string $client;

    /**
     * Nombre maximum de devis à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Date maximum.
     */
    #[Optional]
    public ?\DateTimeInterface $maxDate;

    /**
     * Date minimum.
     */
    #[Optional]
    public ?\DateTimeInterface $minDate;

    /**
     * Nombre de devis à ignorer (pagination).
     */
    #[Optional]
    public ?int $skip;

    /**
     * Champ de tri et direction (ex. "date:-1").
     */
    #[Optional]
    public ?string $sort;

    /**
     * Filtre par état du devis.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Filtre par type de document.
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
     * Nombre maximum de devis à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Date maximum.
     */
    public function withMaxDate(\DateTimeInterface $maxDate): self
    {
        $self = clone $this;
        $self['maxDate'] = $maxDate;

        return $self;
    }

    /**
     * Date minimum.
     */
    public function withMinDate(\DateTimeInterface $minDate): self
    {
        $self = clone $this;
        $self['minDate'] = $minDate;

        return $self;
    }

    /**
     * Nombre de devis à ignorer (pagination).
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Champ de tri et direction (ex. "date:-1").
     */
    public function withSort(string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Filtre par état du devis.
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
     * Filtre par type de document.
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
