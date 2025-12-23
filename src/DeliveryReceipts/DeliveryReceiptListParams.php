<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\DeliveryReceipts\DeliveryReceiptListParams\State;

/**
 * Récupère la liste des bons de livraison avec pagination, tri et filtres.
 *
 * **Filtres disponibles:**
 * - `state`: État du bon de livraison
 * - `client`: ID du client
 * - `minDate` / `maxDate`: Plage de dates
 *
 * **Réponse:**
 * - `receipts`: Liste des bons de livraison
 * - `total`: Nombre total
 * - `skip` et `limit`: Paramètres de pagination
 *
 * @see Wuro\Services\DeliveryReceiptsService::list()
 *
 * @phpstan-type DeliveryReceiptListParamsShape = array{
 *   client?: string|null,
 *   limit?: int|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 * }
 */
final class DeliveryReceiptListParams implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filtre par ID du client.
     */
    #[Optional]
    public ?string $client;

    /**
     * Nombre maximum de bons à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Nombre de bons à ignorer (pagination).
     */
    #[Optional]
    public ?int $skip;

    /**
     * Champ de tri et direction.
     */
    #[Optional]
    public ?string $sort;

    /**
     * Filtre par état.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

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
     */
    public static function with(
        ?string $client = null,
        ?int $limit = null,
        ?int $skip = null,
        ?string $sort = null,
        State|string|null $state = null,
    ): self {
        $self = new self;

        null !== $client && $self['client'] = $client;
        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $sort && $self['sort'] = $sort;
        null !== $state && $self['state'] = $state;

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
     * Nombre maximum de bons à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Nombre de bons à ignorer (pagination).
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Champ de tri et direction.
     */
    public function withSort(string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Filtre par état.
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
