<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AbsenceTypeShape from \Wuro\AbsenceTypes\AbsenceType
 *
 * @phpstan-type AbsenceTypeUpdateResponseShape = array{
 *   absenceType?: null|AbsenceType|AbsenceTypeShape
 * }
 */
final class AbsenceTypeUpdateResponse implements BaseModel
{
    /** @use SdkModel<AbsenceTypeUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?AbsenceType $absenceType;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AbsenceType|AbsenceTypeShape|null $absenceType
     */
    public static function with(AbsenceType|array|null $absenceType = null): self
    {
        $self = new self;

        null !== $absenceType && $self['absenceType'] = $absenceType;

        return $self;
    }

    /**
     * @param AbsenceType|AbsenceTypeShape $absenceType
     */
    public function withAbsenceType(AbsenceType|array $absenceType): self
    {
        $self = clone $this;
        $self['absenceType'] = $absenceType;

        return $self;
    }
}
