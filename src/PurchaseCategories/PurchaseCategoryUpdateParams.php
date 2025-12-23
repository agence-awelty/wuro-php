<?php

declare(strict_types=1);

namespace Wuro\PurchaseCategories;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\PurchaseCategories\PurchaseCategoryUpdateParams\State;

/**
 * Met à jour une catégorie d'achat existante.
 *
 * **Modifications possibles:**
 * - Renommer la catégorie
 * - Activer/désactiver la catégorie
 *
 * **États:**
 * - `active` : Catégorie visible et utilisable
 * - `inactive` : Catégorie masquée
 *
 * @see Wuro\Services\PurchaseCategoriesService::update()
 *
 * @phpstan-type PurchaseCategoryUpdateParamsShape = array{
 *   name?: string|null, state?: null|State|value-of<State>
 * }
 */
final class PurchaseCategoryUpdateParams implements BaseModel
{
    /** @use SdkModel<PurchaseCategoryUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nouveau nom de la catégorie.
     */
    #[Optional]
    public ?string $name;

    /**
     * État de la catégorie.
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
        ?string $name = null,
        State|string|null $state = null
    ): self {
        $self = new self;

        null !== $name && $self['name'] = $name;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    /**
     * Nouveau nom de la catégorie.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * État de la catégorie.
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
