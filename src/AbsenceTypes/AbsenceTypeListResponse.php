<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AbsenceTypeShape from \Wuro\AbsenceTypes\AbsenceType
 *
 * @phpstan-type AbsenceTypeListResponseShape = array{
 *   absenceTypes?: list<AbsenceTypeShape>|null,
 *   limit?: int|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class AbsenceTypeListResponse implements BaseModel
{
    /** @use SdkModel<AbsenceTypeListResponseShape> */
    use SdkModel;

    /**
     * Tableau des types d'absence.
     *
     * @var list<AbsenceType>|null $absenceTypes
     */
    #[Optional(list: AbsenceType::class)]
    public ?array $absenceTypes;

    /**
     * Limite utilisée pour la pagination.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Offset utilisé pour la pagination.
     */
    #[Optional]
    public ?int $skip;

    /**
     * Nombre total de types d'absence.
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
     * @param list<AbsenceTypeShape>|null $absenceTypes
     */
    public static function with(
        ?array $absenceTypes = null,
        ?int $limit = null,
        ?int $skip = null,
        ?int $total = null,
    ): self {
        $self = new self;

        null !== $absenceTypes && $self['absenceTypes'] = $absenceTypes;
        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Tableau des types d'absence.
     *
     * @param list<AbsenceTypeShape> $absenceTypes
     */
    public function withAbsenceTypes(array $absenceTypes): self
    {
        $self = clone $this;
        $self['absenceTypes'] = $absenceTypes;

        return $self;
    }

    /**
     * Limite utilisée pour la pagination.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Offset utilisé pour la pagination.
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Nombre total de types d'absence.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
