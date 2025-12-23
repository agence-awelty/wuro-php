<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Clients\ClientListParams\State;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère la liste de tous les clients de l'entreprise avec pagination, tri et recherche.
 *
 * ## Recherche
 *
 * Le paramètre `search` permet une recherche textuelle dans :
 * - Le nom du client
 * - L'email
 * - Le numéro de téléphone
 * - Le code client
 *
 * ## Tri
 *
 * Utilisez `sort` avec le format `champ:direction` où direction est 1 (asc) ou -1 (desc).
 * Exemples : "name:1", "createdAt:-1"
 *
 * @see Wuro\Services\ClientsService::list()
 *
 * @phpstan-type ClientListParamsShape = array{
 *   limit?: int|null,
 *   search?: string|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 * }
 */
final class ClientListParams implements BaseModel
{
    /** @use SdkModel<ClientListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nombre maximum de clients à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Recherche textuelle dans nom, email, téléphone, code client.
     */
    #[Optional]
    public ?string $search;

    /**
     * Nombre de clients à ignorer (pagination).
     */
    #[Optional]
    public ?int $skip;

    /**
     * Champ et direction de tri (ex. "name:1" pour tri alphabétique).
     */
    #[Optional]
    public ?string $sort;

    /**
     * Filtrer par état (active = visible, inactive = archivé).
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
        ?int $limit = null,
        ?string $search = null,
        ?int $skip = null,
        ?string $sort = null,
        State|string|null $state = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $search && $self['search'] = $search;
        null !== $skip && $self['skip'] = $skip;
        null !== $sort && $self['sort'] = $sort;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    /**
     * Nombre maximum de clients à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Recherche textuelle dans nom, email, téléphone, code client.
     */
    public function withSearch(string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Nombre de clients à ignorer (pagination).
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Champ et direction de tri (ex. "name:1" pour tri alphabétique).
     */
    public function withSort(string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Filtrer par état (active = visible, inactive = archivé).
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
