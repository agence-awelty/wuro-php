<?php

declare(strict_types=1);

namespace Wuro\Companies\Position\PositionCreateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type RightShape = array{
 *   checked?: bool|null, group?: string|null, name?: string|null
 * }
 */
final class Right implements BaseModel
{
    /** @use SdkModel<RightShape> */
    use SdkModel;

    /**
     * Droit activé ou non.
     */
    #[Optional]
    public ?bool $checked;

    /**
     * Groupe du droit.
     */
    #[Optional]
    public ?string $group;

    /**
     * Nom du droit.
     */
    #[Optional]
    public ?string $name;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?bool $checked = null,
        ?string $group = null,
        ?string $name = null
    ): self {
        $self = new self;

        null !== $checked && $self['checked'] = $checked;
        null !== $group && $self['group'] = $group;
        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * Droit activé ou non.
     */
    public function withChecked(bool $checked): self
    {
        $self = clone $this;
        $self['checked'] = $checked;

        return $self;
    }

    /**
     * Groupe du droit.
     */
    public function withGroup(string $group): self
    {
        $self = clone $this;
        $self['group'] = $group;

        return $self;
    }

    /**
     * Nom du droit.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
