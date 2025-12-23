<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AbsenceShape from \Wuro\Absences\Absence
 *
 * @phpstan-type AbsenceNewResponseShape = array{
 *   newAbsence?: null|Absence|AbsenceShape
 * }
 */
final class AbsenceNewResponse implements BaseModel
{
    /** @use SdkModel<AbsenceNewResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Absence $newAbsence;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Absence|AbsenceShape|null $newAbsence
     */
    public static function with(Absence|array|null $newAbsence = null): self
    {
        $self = new self;

        null !== $newAbsence && $self['newAbsence'] = $newAbsence;

        return $self;
    }

    /**
     * @param Absence|AbsenceShape $newAbsence
     */
    public function withNewAbsence(Absence|array $newAbsence): self
    {
        $self = clone $this;
        $self['newAbsence'] = $newAbsence;

        return $self;
    }
}
