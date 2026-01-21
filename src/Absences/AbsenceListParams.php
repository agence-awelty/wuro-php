<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Absences\AbsenceListParams\PositionTo;
use Wuro\Absences\AbsenceListParams\State;
use Wuro\Absences\AbsenceListParams\Type;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère la liste des absences de l'entreprise avec de nombreuses options de filtrage.
 *
 * Cette route est particulièrement utile pour :
 * - Afficher le calendrier des absences d'équipe
 * - Filtrer les absences par collaborateur ou période
 * - Obtenir les absences du jour (pour un dashboard RH)
 *
 * ## Filtres de période
 *
 * Plusieurs modes de filtrage temporel sont disponibles :
 *
 * - **month + year** : Absences sur un mois calendaire (avec marge du mois précédent/suivant)
 * - **today** : Absences en cours aujourd'hui (distingue matin/après-midi)
 * - **from / to** : Filtrer par date de début ou fin exacte
 * - **inPeriod** : Absences chevauchant une période donnée
 *
 * ## Gestion des demi-journées
 *
 * Les absences peuvent commencer ou finir en demi-journée :
 * - **full** : Journée entière
 * - **half-am** : Matin uniquement
 * - **half-pm** : Après-midi uniquement
 *
 * @see Wuro\Services\AbsencesService::list()
 *
 * @phpstan-import-type PositionToVariants from \Wuro\Absences\AbsenceListParams\PositionTo
 * @phpstan-import-type TypeVariants from \Wuro\Absences\AbsenceListParams\Type
 * @phpstan-import-type PositionToShape from \Wuro\Absences\AbsenceListParams\PositionTo
 * @phpstan-import-type TypeShape from \Wuro\Absences\AbsenceListParams\Type
 *
 * @phpstan-type AbsenceListParamsShape = array{
 *   from?: \DateTimeInterface|null,
 *   inPeriod?: list<\DateTimeInterface>|null,
 *   limit?: int|null,
 *   month?: int|null,
 *   positionTo?: PositionToShape|null,
 *   skip?: int|null,
 *   sort?: string|null,
 *   state?: null|State|value-of<State>,
 *   to?: \DateTimeInterface|null,
 *   today?: bool|null,
 *   type?: TypeShape|null,
 *   userTo?: string|null,
 *   year?: int|null,
 * }
 */
final class AbsenceListParams implements BaseModel
{
    /** @use SdkModel<AbsenceListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filtrer par date de début (format ISO).
     */
    #[Optional]
    public ?\DateTimeInterface $from;

    /**
     * Tableau de 2 dates [début, fin] pour obtenir les absences chevauchant cette période.
     * Utile pour le calendrier : récupère les absences qui commencent, finissent ou traversent la période.
     *
     * @var list<\DateTimeInterface>|null $inPeriod
     */
    #[Optional(list: '\DateTimeInterface')]
    public ?array $inPeriod;

    /**
     * Nombre maximum d'absences à retourner.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Mois pour le filtre calendrier (1-12). Requiert year.
     */
    #[Optional]
    public ?int $month;

    /**
     * Filtrer par poste concerné. Valeurs spéciales :
     * - **all** : Tous les postes
     * - **onlyActive** : Postes actifs uniquement
     * - ID de poste pour un poste spécifique
     * - Tableau d'IDs pour plusieurs postes
     *
     * @var PositionToVariants|null $positionTo
     */
    #[Optional(union: PositionTo::class)]
    public string|array|null $positionTo;

    /**
     * Nombre d'absences à ignorer (pagination).
     */
    #[Optional]
    public ?int $skip;

    /**
     * Tri des résultats (ex. "from:-1" pour les plus récentes d'abord).
     */
    #[Optional]
    public ?string $sort;

    /**
     * Filtrer par état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée
     * - **rejected** : Refusée
     * - **canceled** : Annulée par le collaborateur
     * - **inactive** : Supprimée (soft delete)
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Filtrer par date de fin (format ISO).
     */
    #[Optional]
    public ?\DateTimeInterface $to;

    /**
     * Si true, retourne uniquement les absences du jour en cours.
     */
    #[Optional]
    public ?bool $today;

    /**
     * Filtrer par type d'absence (peut être un tableau).
     *
     * @var TypeVariants|null $type
     */
    #[Optional(union: Type::class)]
    public string|array|null $type;

    /**
     * Filtrer par utilisateur concerné.
     */
    #[Optional]
    public ?string $userTo;

    /**
     * Année pour le filtre calendrier. Requiert month.
     */
    #[Optional]
    public ?int $year;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<\DateTimeInterface>|null $inPeriod
     * @param PositionToShape|null $positionTo
     * @param State|value-of<State>|null $state
     * @param TypeShape|null $type
     */
    public static function with(
        ?\DateTimeInterface $from = null,
        ?array $inPeriod = null,
        ?int $limit = null,
        ?int $month = null,
        string|array|null $positionTo = null,
        ?int $skip = null,
        ?string $sort = null,
        State|string|null $state = null,
        ?\DateTimeInterface $to = null,
        ?bool $today = null,
        string|array|null $type = null,
        ?string $userTo = null,
        ?int $year = null,
    ): self {
        $self = new self;

        null !== $from && $self['from'] = $from;
        null !== $inPeriod && $self['inPeriod'] = $inPeriod;
        null !== $limit && $self['limit'] = $limit;
        null !== $month && $self['month'] = $month;
        null !== $positionTo && $self['positionTo'] = $positionTo;
        null !== $skip && $self['skip'] = $skip;
        null !== $sort && $self['sort'] = $sort;
        null !== $state && $self['state'] = $state;
        null !== $to && $self['to'] = $to;
        null !== $today && $self['today'] = $today;
        null !== $type && $self['type'] = $type;
        null !== $userTo && $self['userTo'] = $userTo;
        null !== $year && $self['year'] = $year;

        return $self;
    }

    /**
     * Filtrer par date de début (format ISO).
     */
    public function withFrom(\DateTimeInterface $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Tableau de 2 dates [début, fin] pour obtenir les absences chevauchant cette période.
     * Utile pour le calendrier : récupère les absences qui commencent, finissent ou traversent la période.
     *
     * @param list<\DateTimeInterface> $inPeriod
     */
    public function withInPeriod(array $inPeriod): self
    {
        $self = clone $this;
        $self['inPeriod'] = $inPeriod;

        return $self;
    }

    /**
     * Nombre maximum d'absences à retourner.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Mois pour le filtre calendrier (1-12). Requiert year.
     */
    public function withMonth(int $month): self
    {
        $self = clone $this;
        $self['month'] = $month;

        return $self;
    }

    /**
     * Filtrer par poste concerné. Valeurs spéciales :
     * - **all** : Tous les postes
     * - **onlyActive** : Postes actifs uniquement
     * - ID de poste pour un poste spécifique
     * - Tableau d'IDs pour plusieurs postes
     *
     * @param PositionToShape $positionTo
     */
    public function withPositionTo(string|array $positionTo): self
    {
        $self = clone $this;
        $self['positionTo'] = $positionTo;

        return $self;
    }

    /**
     * Nombre d'absences à ignorer (pagination).
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Tri des résultats (ex. "from:-1" pour les plus récentes d'abord).
     */
    public function withSort(string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Filtrer par état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée
     * - **rejected** : Refusée
     * - **canceled** : Annulée par le collaborateur
     * - **inactive** : Supprimée (soft delete)
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
     * Filtrer par date de fin (format ISO).
     */
    public function withTo(\DateTimeInterface $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Si true, retourne uniquement les absences du jour en cours.
     */
    public function withToday(bool $today): self
    {
        $self = clone $this;
        $self['today'] = $today;

        return $self;
    }

    /**
     * Filtrer par type d'absence (peut être un tableau).
     *
     * @param TypeShape $type
     */
    public function withType(string|array $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Filtrer par utilisateur concerné.
     */
    public function withUserTo(string $userTo): self
    {
        $self = clone $this;
        $self['userTo'] = $userTo;

        return $self;
    }

    /**
     * Année pour le filtre calendrier. Requiert month.
     */
    public function withYear(int $year): self
    {
        $self = clone $this;
        $self['year'] = $year;

        return $self;
    }
}
