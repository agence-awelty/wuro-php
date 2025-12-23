<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AbsenceShape from \Wuro\Absences\Absence
 *
 * @phpstan-type AbsenceDeleteResponseShape = array{
 *   absence?: null|Absence|AbsenceShape
 * }
 */
final class AbsenceDeleteResponse implements BaseModel
{
    /** @use SdkModel<AbsenceDeleteResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Absence $absence;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Absence|AbsenceShape|null $absence
     */
    public static function with(Absence|array|null $absence = null): self
    {
        $self = new self;

        null !== $absence && $self['absence'] = $absence;

        return $self;
    }

    /**
     * @param Absence|AbsenceShape $absence
     */
    public function withAbsence(Absence|array $absence): self
    {
        $self = clone $this;
        $self['absence'] = $absence;

        return $self;
    }
}
