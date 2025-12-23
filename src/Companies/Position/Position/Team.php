<?php

declare(strict_types=1);

namespace Wuro\Companies\Position\Position;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type TeamShape = array{
 *   default?: bool|null, rightType?: string|null, team?: string|null
 * }
 */
final class Team implements BaseModel
{
    /** @use SdkModel<TeamShape> */
    use SdkModel;

    /**
     * Whether this is the default team.
     */
    #[Optional]
    public ?bool $default;

    /**
     * Type of rights.
     */
    #[Optional]
    public ?string $rightType;

    /**
     * ID of the team.
     */
    #[Optional]
    public ?string $team;

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
        ?bool $default = null,
        ?string $rightType = null,
        ?string $team = null
    ): self {
        $self = new self;

        null !== $default && $self['default'] = $default;
        null !== $rightType && $self['rightType'] = $rightType;
        null !== $team && $self['team'] = $team;

        return $self;
    }

    /**
     * Whether this is the default team.
     */
    public function withDefault(bool $default): self
    {
        $self = clone $this;
        $self['default'] = $default;

        return $self;
    }

    /**
     * Type of rights.
     */
    public function withRightType(string $rightType): self
    {
        $self = clone $this;
        $self['rightType'] = $rightType;

        return $self;
    }

    /**
     * ID of the team.
     */
    public function withTeam(string $team): self
    {
        $self = clone $this;
        $self['team'] = $team;

        return $self;
    }
}
