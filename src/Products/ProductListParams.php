<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Products\ProductListParams\State;

/**
 * Récupère la liste de tous les produits du catalogue avec pagination, tri et recherche.
 *
 * ## Recherche
 *
 * Le paramètre `search` permet une recherche textuelle dans :
 * - Le nom du produit
 * - La référence
 * - La description
 *
 * ## Filtrage par catégorie
 *
 * Utilisez `category` pour filtrer par catégorie de produit.
 *
 * ## Tri
 *
 * Utilisez `sort` avec le format `champ:direction` où direction est 1 (asc) ou -1 (desc).
 *
 * @see Wuro\Services\ProductsService::list()
 *
 * @phpstan-type ProductListParamsShape = array{
 *   category?: string|null,
 *   limit?: int|null,
 *   search?: string|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 * }
 */
final class ProductListParams implements BaseModel
{
    /** @use SdkModel<ProductListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filtrer par catégorie de produit.
     */
    #[Optional]
    public ?string $category;

    /**
     * Nombre maximum de produits à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Recherche textuelle dans nom, référence, description.
     */
    #[Optional]
    public ?string $search;

    /**
     * Nombre de produits à ignorer (pagination).
     */
    #[Optional]
    public ?int $skip;

    /**
     * Champ et direction de tri (ex. "name:1", "price:-1").
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
        ?string $category = null,
        ?int $limit = null,
        ?string $search = null,
        ?int $skip = null,
        ?string $sort = null,
        State|string|null $state = null,
    ): self {
        $self = new self;

        null !== $category && $self['category'] = $category;
        null !== $limit && $self['limit'] = $limit;
        null !== $search && $self['search'] = $search;
        null !== $skip && $self['skip'] = $skip;
        null !== $sort && $self['sort'] = $sort;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    /**
     * Filtrer par catégorie de produit.
     */
    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Nombre maximum de produits à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Recherche textuelle dans nom, référence, description.
     */
    public function withSearch(string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Nombre de produits à ignorer (pagination).
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Champ et direction de tri (ex. "name:1", "price:-1").
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
