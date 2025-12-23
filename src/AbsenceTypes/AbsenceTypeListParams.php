<?php

declare(strict_types=1);

namespace Wuro\AbsenceTypes;

use Wuro\AbsenceTypes\AbsenceTypeListParams\State;
use Wuro\AbsenceTypes\AbsenceTypeListParams\Type;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère la liste de tous les types d'absence configurés pour l'entreprise.
 *
 * Les types d'absence permettent de catégoriser les absences (congés payés, RTT, maladie, télétravail, etc.).
 * Chaque type peut avoir une icône et des couleurs personnalisées pour une meilleure visualisation dans le calendrier.
 *
 * Les types peuvent être de deux catégories :
 * - **absence** : Congés, RTT, maladie, etc.
 * - **event** : Événements comme les formations, réunions, etc.
 *
 * @see Wuro\Services\AbsenceTypesService::list()
 *
 * @phpstan-type AbsenceTypeListParamsShape = array{
 *   limit?: int|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class AbsenceTypeListParams implements BaseModel
{
    /** @use SdkModel<AbsenceTypeListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nombre maximum de types d'absence à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Nombre de types d'absence à ignorer pour la pagination.
     */
    #[Optional]
    public ?int $skip;

    /**
     * Champ et direction de tri (ex. "name:1" pour tri alphabétique ascendant).
     */
    #[Optional]
    public ?string $sort;

    /**
     * Filtrer par état (active/inactive).
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Filtrer par catégorie (absence ou event).
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?int $limit = null,
        ?int $skip = null,
        ?string $sort = null,
        State|string|null $state = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $sort && $self['sort'] = $sort;
        null !== $state && $self['state'] = $state;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Nombre maximum de types d'absence à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Nombre de types d'absence à ignorer pour la pagination.
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Champ et direction de tri (ex. "name:1" pour tri alphabétique ascendant).
     */
    public function withSort(string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Filtrer par état (active/inactive).
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * Filtrer par catégorie (absence ou event).
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
