<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AbsenceShape from \Wuro\Absences\Absence
 *
 * @phpstan-type AbsenceUpdateResponseShape = array{
 *   updatedAbsence?: null|Absence|AbsenceShape
 * }
 */
final class AbsenceUpdateResponse implements BaseModel
{
    /** @use SdkModel<AbsenceUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Absence $updatedAbsence;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Absence|AbsenceShape|null $updatedAbsence
     */
    public static function with(Absence|array|null $updatedAbsence = null): self
    {
        $self = new self;

        null !== $updatedAbsence && $self['updatedAbsence'] = $updatedAbsence;

        return $self;
    }

    /**
     * @param Absence|AbsenceShape $updatedAbsence
     */
    public function withUpdatedAbsence(Absence|array $updatedAbsence): self
    {
        $self = clone $this;
        $self['updatedAbsence'] = $updatedAbsence;

        return $self;
    }
}
