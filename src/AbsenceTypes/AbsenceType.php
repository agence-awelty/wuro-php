<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes;

use Wuro\AbsenceTypes\AbsenceType\State;
use Wuro\AbsenceTypes\AbsenceType\Type;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type AbsenceTypeShape = array{
 *   _id?: string|null,
 *   backgroundColor?: string|null,
 *   backgroundColorRgb?: string|null,
 *   color?: string|null,
 *   icon?: string|null,
 *   name?: string|null,
 *   state?: null|State|value-of<State>,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class AbsenceType implements BaseModel
{
    /** @use SdkModel<AbsenceTypeShape> */
    use SdkModel;

    /**
     * Unique identifier for the absence type.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Background color for the absence type.
     */
    #[Optional]
    public ?string $backgroundColor;

    /**
     * Background color in RGB format.
     */
    #[Optional]
    public ?string $backgroundColorRgb;

    /**
     * Text color for the absence type.
     */
    #[Optional]
    public ?string $color;

    /**
     * Icon for the absence type.
     */
    #[Optional]
    public ?string $icon;

    /**
     * Name of the absence type.
     */
    #[Optional]
    public ?string $name;

    /**
     * State of the absence type.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Type of the absence type.
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
        ?string $_id = null,
        ?string $backgroundColor = null,
        ?string $backgroundColorRgb = null,
        ?string $color = null,
        ?string $icon = null,
        ?string $name = null,
        State|string|null $state = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $backgroundColor && $self['backgroundColor'] = $backgroundColor;
        null !== $backgroundColorRgb && $self['backgroundColorRgb'] = $backgroundColorRgb;
        null !== $color && $self['color'] = $color;
        null !== $icon && $self['icon'] = $icon;
        null !== $name && $self['name'] = $name;
        null !== $state && $self['state'] = $state;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Unique identifier for the absence type.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Background color for the absence type.
     */
    public function withBackgroundColor(string $backgroundColor): self
    {
        $self = clone $this;
        $self['backgroundColor'] = $backgroundColor;

        return $self;
    }

    /**
     * Background color in RGB format.
     */
    public function withBackgroundColorRgb(string $backgroundColorRgb): self
    {
        $self = clone $this;
        $self['backgroundColorRgb'] = $backgroundColorRgb;

        return $self;
    }

    /**
     * Text color for the absence type.
     */
    public function withColor(string $color): self
    {
        $self = clone $this;
        $self['color'] = $color;

        return $self;
    }

    /**
     * Icon for the absence type.
     */
    public function withIcon(string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

        return $self;
    }

    /**
     * Name of the absence type.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * State of the absence type.
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
     * Type of the absence type.
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
