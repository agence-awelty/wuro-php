<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AbsenceTypeShape from \Wuro\AbsenceTypes\AbsenceType
 *
 * @phpstan-type AbsenceTypeNewResponseShape = array{
 *   newAbsenceType?: null|AbsenceType|AbsenceTypeShape
 * }
 */
final class AbsenceTypeNewResponse implements BaseModel
{
    /** @use SdkModel<AbsenceTypeNewResponseShape> */
    use SdkModel;

    #[Optional]
    public ?AbsenceType $newAbsenceType;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AbsenceType|AbsenceTypeShape|null $newAbsenceType
     */
    public static function with(AbsenceType|array|null $newAbsenceType = null): self
    {
        $self = new self;

        null !== $newAbsenceType && $self['newAbsenceType'] = $newAbsenceType;

        return $self;
    }

    /**
     * @param AbsenceType|AbsenceTypeShape $newAbsenceType
     */
    public function withNewAbsenceType(AbsenceType|array $newAbsenceType): self
    {
        $self = clone $this;
        $self['newAbsenceType'] = $newAbsenceType;

        return $self;
    }
}
