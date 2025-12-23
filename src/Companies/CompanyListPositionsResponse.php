<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Companies\Position\Position;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PositionShape from \Wuro\Companies\Position\Position
 *
 * @phpstan-type CompanyListPositionsResponseShape = array{
 *   positions?: list<PositionShape>|null
 * }
 */
final class CompanyListPositionsResponse implements BaseModel
{
    /** @use SdkModel<CompanyListPositionsResponseShape> */
    use SdkModel;

    /** @var list<Position>|null $positions */
    #[Optional(list: Position::class)]
    public ?array $positions;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<PositionShape>|null $positions
     */
    public static function with(?array $positions = null): self
    {
        $self = new self;

        null !== $positions && $self['positions'] = $positions;

        return $self;
    }

    /**
     * @param list<PositionShape> $positions
     */
    public function withPositions(array $positions): self
    {
        $self = clone $this;
        $self['positions'] = $positions;

        return $self;
    }
}
