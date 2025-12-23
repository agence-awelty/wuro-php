<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes;

use Wuro\AbsenceTypes\AbsenceTypeUpdateParams\State;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Met à jour les informations d'un type d'absence existant.
 *
 * Vous pouvez modifier :
 * - Le nom affiché
 * - L'icône représentative
 * - Les couleurs (fond et texte) pour la visualisation calendrier
 * - L'état (active/inactive) pour masquer sans supprimer
 *
 * **Note** : Désactiver un type n'affecte pas les absences déjà créées avec ce type.
 *
 * @see Wuro\Services\AbsenceTypesService::update()
 *
 * @phpstan-type AbsenceTypeUpdateParamsShape = array{
 *   backgroundColor?: string|null,
 *   backgroundColorRgb?: string|null,
 *   color?: string|null,
 *   icon?: string|null,
 *   name?: string|null,
 *   state?: null|State|value-of<State>,
 * }
 */
final class AbsenceTypeUpdateParams implements BaseModel
{
    /** @use SdkModel<AbsenceTypeUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Couleur de fond hexadécimale (ex. "#3498db").
     */
    #[Optional]
    public ?string $backgroundColor;

    /**
     * Couleur de fond en format RGB (ex. "52, 152, 219").
     */
    #[Optional]
    public ?string $backgroundColorRgb;

    /**
     * Couleur du texte hexadécimale (ex. "#ffffff").
     */
    #[Optional]
    public ?string $color;

    /**
     * Icône Font Awesome ou autre (ex. "fa-umbrella-beach").
     */
    #[Optional]
    public ?string $icon;

    /**
     * Nom du type d'absence (ex. "Congés payés", "RTT", "Maladie").
     */
    #[Optional]
    public ?string $name;

    /**
     * État du type (inactive = masqué dans les choix).
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
        ?string $backgroundColor = null,
        ?string $backgroundColorRgb = null,
        ?string $color = null,
        ?string $icon = null,
        ?string $name = null,
        State|string|null $state = null,
    ): self {
        $self = new self;

        null !== $backgroundColor && $self['backgroundColor'] = $backgroundColor;
        null !== $backgroundColorRgb && $self['backgroundColorRgb'] = $backgroundColorRgb;
        null !== $color && $self['color'] = $color;
        null !== $icon && $self['icon'] = $icon;
        null !== $name && $self['name'] = $name;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    /**
     * Couleur de fond hexadécimale (ex. "#3498db").
     */
    public function withBackgroundColor(string $backgroundColor): self
    {
        $self = clone $this;
        $self['backgroundColor'] = $backgroundColor;

        return $self;
    }

    /**
     * Couleur de fond en format RGB (ex. "52, 152, 219").
     */
    public function withBackgroundColorRgb(string $backgroundColorRgb): self
    {
        $self = clone $this;
        $self['backgroundColorRgb'] = $backgroundColorRgb;

        return $self;
    }

    /**
     * Couleur du texte hexadécimale (ex. "#ffffff").
     */
    public function withColor(string $color): self
    {
        $self = clone $this;
        $self['color'] = $color;

        return $self;
    }

    /**
     * Icône Font Awesome ou autre (ex. "fa-umbrella-beach").
     */
    public function withIcon(string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

        return $self;
    }

    /**
     * Nom du type d'absence (ex. "Congés payés", "RTT", "Maladie").
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * État du type (inactive = masqué dans les choix).
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
