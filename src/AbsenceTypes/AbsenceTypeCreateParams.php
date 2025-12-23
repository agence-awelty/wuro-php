<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes;

use Wuro\AbsenceTypes\AbsenceTypeCreateParams\State;
use Wuro\AbsenceTypes\AbsenceTypeCreateParams\Type;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Crée un nouveau type d'absence pour l'entreprise.
 *
 * Les types d'absence permettent de catégoriser les demandes d'absence des collaborateurs.
 * Exemples de types courants :
 * - Congés payés
 * - RTT
 * - Congé maladie
 * - Télétravail
 * - Formation
 * - Événement client
 *
 * Vous pouvez personnaliser l'apparence de chaque type avec une icône et des couleurs
 * pour faciliter la lecture du calendrier d'équipe.
 *
 * @see Wuro\Services\AbsenceTypesService::create()
 *
 * @phpstan-type AbsenceTypeCreateParamsShape = array{
 *   name: string,
 *   backgroundColor?: string|null,
 *   backgroundColorRgb?: string|null,
 *   color?: string|null,
 *   icon?: string|null,
 *   state?: null|State|value-of<State>,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class AbsenceTypeCreateParams implements BaseModel
{
    /** @use SdkModel<AbsenceTypeCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nom du type d'absence (obligatoire).
     */
    #[Required]
    public string $name;

    /**
     * Couleur de fond pour l'affichage calendrier.
     */
    #[Optional]
    public ?string $backgroundColor;

    /**
     * Couleur de fond en format RGB.
     */
    #[Optional]
    public ?string $backgroundColorRgb;

    /**
     * Couleur du texte.
     */
    #[Optional]
    public ?string $color;

    /**
     * Icône Font Awesome (ex. "fa-umbrella-beach", "fa-briefcase-medical").
     */
    #[Optional]
    public ?string $icon;

    /**
     * État initial (active par défaut).
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Catégorie du type :
     * - **absence** : Congés, RTT, maladie (absence du collaborateur)
     * - **event** : Formation, réunion (présent mais non disponible)
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * `new AbsenceTypeCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AbsenceTypeCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AbsenceTypeCreateParams)->withName(...)
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
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        string $name,
        ?string $backgroundColor = null,
        ?string $backgroundColorRgb = null,
        ?string $color = null,
        ?string $icon = null,
        State|string|null $state = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $backgroundColor && $self['backgroundColor'] = $backgroundColor;
        null !== $backgroundColorRgb && $self['backgroundColorRgb'] = $backgroundColorRgb;
        null !== $color && $self['color'] = $color;
        null !== $icon && $self['icon'] = $icon;
        null !== $state && $self['state'] = $state;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Nom du type d'absence (obligatoire).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Couleur de fond pour l'affichage calendrier.
     */
    public function withBackgroundColor(string $backgroundColor): self
    {
        $self = clone $this;
        $self['backgroundColor'] = $backgroundColor;

        return $self;
    }

    /**
     * Couleur de fond en format RGB.
     */
    public function withBackgroundColorRgb(string $backgroundColorRgb): self
    {
        $self = clone $this;
        $self['backgroundColorRgb'] = $backgroundColorRgb;

        return $self;
    }

    /**
     * Couleur du texte.
     */
    public function withColor(string $color): self
    {
        $self = clone $this;
        $self['color'] = $color;

        return $self;
    }

    /**
     * Icône Font Awesome (ex. "fa-umbrella-beach", "fa-briefcase-medical").
     */
    public function withIcon(string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

        return $self;
    }

    /**
     * État initial (active par défaut).
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
     * Catégorie du type :
     * - **absence** : Congés, RTT, maladie (absence du collaborateur)
     * - **event** : Formation, réunion (présent mais non disponible)
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
