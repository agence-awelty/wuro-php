<?php

declare(strict_types=1);

namespace Wuro\Companies\Position;

use Wuro\Companies\Position\PositionUpdateParams\Right;
use Wuro\Companies\Position\PositionUpdateParams\State;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Met à jour un poste (position) existant dans une entreprise.
 *
 * **Modifications possibles:**
 * - Changer le type de poste
 * - Modifier les droits spécifiques
 * - Activer/désactiver le poste
 *
 * **États du poste:**
 * - `active` : Poste actif, l'utilisateur a accès à l'entreprise
 * - `inactive` : Poste désactivé, accès révoqué
 *
 * **Événement déclenché:** UPDATE_POSITION
 *
 * @see Wuro\Services\Companies\PositionService::update()
 *
 * @phpstan-import-type RightShape from \Wuro\Companies\Position\PositionUpdateParams\Right
 *
 * @phpstan-type PositionUpdateParamsShape = array{
 *   company: string,
 *   rights?: list<RightShape>|null,
 *   state?: null|State|value-of<State>,
 *   type?: string|null,
 * }
 */
final class PositionUpdateParams implements BaseModel
{
    /** @use SdkModel<PositionUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $company;

    /**
     * Liste des droits spécifiques.
     *
     * @var list<Right>|null $rights
     */
    #[Optional(list: Right::class)]
    public ?array $rights;

    /**
     * État du poste.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Type de poste (ID du Type de droits).
     */
    #[Optional]
    public ?string $type;

    /**
     * `new PositionUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PositionUpdateParams::with(company: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PositionUpdateParams)->withCompany(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<RightShape>|null $rights
     * @param State|value-of<State>|null $state
     */
    public static function with(
        string $company,
        ?array $rights = null,
        State|string|null $state = null,
        ?string $type = null,
    ): self {
        $self = new self;

        $self['company'] = $company;

        null !== $rights && $self['rights'] = $rights;
        null !== $state && $self['state'] = $state;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    public function withCompany(string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    /**
     * Liste des droits spécifiques.
     *
     * @param list<RightShape> $rights
     */
    public function withRights(array $rights): self
    {
        $self = clone $this;
        $self['rights'] = $rights;

        return $self;
    }

    /**
     * État du poste.
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
     * Type de poste (ID du Type de droits).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
