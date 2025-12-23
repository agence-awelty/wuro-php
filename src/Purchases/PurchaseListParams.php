<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Purchases\PurchaseListParams\State;

/**
 * Récupère la liste de tous les achats/factures fournisseurs avec pagination et filtres.
 *
 * Les achats permettent de suivre les dépenses de l'entreprise (factures fournisseurs,
 * notes de frais, etc.).
 *
 * ## États disponibles
 *
 * - **draft** : Brouillon (pas encore validé)
 * - **waiting** : En attente de paiement
 * - **to_pay** : À payer
 * - **paid** : Payé
 * - **notpaid** : Impayé (échéance dépassée)
 * - **inactive** : Supprimé (soft delete)
 *
 * @see Wuro\Services\PurchasesService::list()
 *
 * @phpstan-type PurchaseListParamsShape = array{
 *   limit?: int|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 *   supplier?: string|null,
 * }
 */
final class PurchaseListParams implements BaseModel
{
    /** @use SdkModel<PurchaseListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nombre maximum d'achats à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Nombre d'achats à ignorer (pagination).
     */
    #[Optional]
    public ?int $skip;

    /**
     * Champ et direction de tri (ex. "date:-1" pour les plus récents).
     */
    #[Optional]
    public ?string $sort;

    /**
     * Filtrer par état de l'achat.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Filtrer par fournisseur (ID du fournisseur).
     */
    #[Optional]
    public ?string $supplier;

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
        ?int $skip = null,
        ?string $sort = null,
        State|string|null $state = null,
        ?string $supplier = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $sort && $self['sort'] = $sort;
        null !== $state && $self['state'] = $state;
        null !== $supplier && $self['supplier'] = $supplier;

        return $self;
    }

    /**
     * Nombre maximum d'achats à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Nombre d'achats à ignorer (pagination).
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Champ et direction de tri (ex. "date:-1" pour les plus récents).
     */
    public function withSort(string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Filtrer par état de l'achat.
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
     * Filtrer par fournisseur (ID du fournisseur).
     */
    public function withSupplier(string $supplier): self
    {
        $self = clone $this;
        $self['supplier'] = $supplier;

        return $self;
    }
}
