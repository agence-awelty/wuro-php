<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AbsenceShape from \Wuro\Absences\Absence
 *
 * @phpstan-type AbsenceListResponseShape = array{
 *   absences?: list<AbsenceShape>|null,
 *   limit?: int|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class AbsenceListResponse implements BaseModel
{
    /** @use SdkModel<AbsenceListResponseShape> */
    use SdkModel;

    /**
     * Tableau des absences correspondant aux filtres.
     *
     * @var list<Absence>|null $absences
     */
    #[Optional(list: Absence::class)]
    public ?array $absences;

    /**
     * Limite utilisée.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Offset utilisé.
     */
    #[Optional]
    public ?int $skip;

    /**
     * Nombre total d'absences (avant pagination).
     */
    #[Optional]
    public ?int $total;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AbsenceShape>|null $absences
     */
    public static function with(
        ?array $absences = null,
        ?int $limit = null,
        ?int $skip = null,
        ?int $total = null,
    ): self {
        $self = new self;

        null !== $absences && $self['absences'] = $absences;
        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Tableau des absences correspondant aux filtres.
     *
     * @param list<AbsenceShape> $absences
     */
    public function withAbsences(array $absences): self
    {
        $self = clone $this;
        $self['absences'] = $absences;

        return $self;
    }

    /**
     * Limite utilisée.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Offset utilisé.
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Nombre total d'absences (avant pagination).
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
