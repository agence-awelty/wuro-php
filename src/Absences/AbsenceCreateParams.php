<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Absences\AbsenceCreateParams\FromMoment;
use Wuro\Absences\AbsenceCreateParams\Log;
use Wuro\Absences\AbsenceCreateParams\State;
use Wuro\Absences\AbsenceCreateParams\ToMoment;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Crée une nouvelle demande d'absence pour un collaborateur.
 *
 * ## Workflow de validation
 *
 * Par défaut, l'absence est créée en état "waiting" (en attente de validation).
 * Le responsable peut ensuite la valider ("accepted") ou la refuser ("rejected").
 *
 * ## Gestion des demi-journées
 *
 * Les absences supportent les demi-journées :
 * - Utilisez `from_moment` et `to_moment` avec les valeurs "full", "half-am" ou "half-pm"
 * - Exemple : absence du lundi après-midi au mercredi matin
 *
 * ## Résolution automatique du collaborateur
 *
 * Si vous fournissez uniquement `positionTo` sans `userTo`,
 * l'API récupère automatiquement l'utilisateur associé au poste.
 *
 * ## Événement déclenché
 *
 * Un événement `CREATE_ABSENCE` est émis après la création,
 * permettant de notifier les responsables de la nouvelle demande.
 *
 * @see Wuro\Services\AbsencesService::create()
 *
 * @phpstan-import-type LogShape from \Wuro\Absences\AbsenceCreateParams\Log
 *
 * @phpstan-type AbsenceCreateParamsShape = array{
 *   from: \DateTimeInterface,
 *   to: \DateTimeInterface,
 *   type: string,
 *   fromMoment?: null|FromMoment|value-of<FromMoment>,
 *   logs?: list<Log|LogShape>|null,
 *   positionTo?: string|null,
 *   state?: null|State|value-of<State>,
 *   toMoment?: null|ToMoment|value-of<ToMoment>,
 *   userTo?: string|null,
 * }
 */
final class AbsenceCreateParams implements BaseModel
{
    /** @use SdkModel<AbsenceCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Date de début de l'absence (obligatoire).
     */
    #[Required]
    public \DateTimeInterface $from;

    /**
     * Date de fin de l'absence (obligatoire).
     */
    #[Required]
    public \DateTimeInterface $to;

    /**
     * Référence vers le type d'absence (obligatoire).
     */
    #[Required]
    public string $type;

    /**
     * Moment de début :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     *
     * @var value-of<FromMoment>|null $fromMoment
     */
    #[Optional('from_moment', enum: FromMoment::class)]
    public ?string $fromMoment;

    /**
     * Historique initial (généralement vide à la création).
     *
     * @var list<Log>|null $logs
     */
    #[Optional(list: Log::class)]
    public ?array $logs;

    /**
     * Poste concerné par l'absence.
     * Si fourni sans userTo, l'utilisateur est résolu automatiquement.
     */
    #[Optional]
    public ?string $positionTo;

    /**
     * État initial de l'absence (waiting par défaut).
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Moment de fin :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     *
     * @var value-of<ToMoment>|null $toMoment
     */
    #[Optional('to_moment', enum: ToMoment::class)]
    public ?string $toMoment;

    /**
     * Utilisateur concerné par l'absence.
     * Optionnel si positionTo est fourni (résolu automatiquement).
     */
    #[Optional]
    public ?string $userTo;

    /**
     * `new AbsenceCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AbsenceCreateParams::with(from: ..., to: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AbsenceCreateParams)->withFrom(...)->withTo(...)->withType(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param FromMoment|value-of<FromMoment>|null $fromMoment
     * @param list<Log|LogShape>|null $logs
     * @param State|value-of<State>|null $state
     * @param ToMoment|value-of<ToMoment>|null $toMoment
     */
    public static function with(
        \DateTimeInterface $from,
        \DateTimeInterface $to,
        string $type,
        FromMoment|string|null $fromMoment = null,
        ?array $logs = null,
        ?string $positionTo = null,
        State|string|null $state = null,
        ToMoment|string|null $toMoment = null,
        ?string $userTo = null,
    ): self {
        $self = new self;

        $self['from'] = $from;
        $self['to'] = $to;
        $self['type'] = $type;

        null !== $fromMoment && $self['fromMoment'] = $fromMoment;
        null !== $logs && $self['logs'] = $logs;
        null !== $positionTo && $self['positionTo'] = $positionTo;
        null !== $state && $self['state'] = $state;
        null !== $toMoment && $self['toMoment'] = $toMoment;
        null !== $userTo && $self['userTo'] = $userTo;

        return $self;
    }

    /**
     * Date de début de l'absence (obligatoire).
     */
    public function withFrom(\DateTimeInterface $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Date de fin de l'absence (obligatoire).
     */
    public function withTo(\DateTimeInterface $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Référence vers le type d'absence (obligatoire).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Moment de début :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     *
     * @param FromMoment|value-of<FromMoment> $fromMoment
     */
    public function withFromMoment(FromMoment|string $fromMoment): self
    {
        $self = clone $this;
        $self['fromMoment'] = $fromMoment;

        return $self;
    }

    /**
     * Historique initial (généralement vide à la création).
     *
     * @param list<Log|LogShape> $logs
     */
    public function withLogs(array $logs): self
    {
        $self = clone $this;
        $self['logs'] = $logs;

        return $self;
    }

    /**
     * Poste concerné par l'absence.
     * Si fourni sans userTo, l'utilisateur est résolu automatiquement.
     */
    public function withPositionTo(string $positionTo): self
    {
        $self = clone $this;
        $self['positionTo'] = $positionTo;

        return $self;
    }

    /**
     * État initial de l'absence (waiting par défaut).
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
     * Moment de fin :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     *
     * @param ToMoment|value-of<ToMoment> $toMoment
     */
    public function withToMoment(ToMoment|string $toMoment): self
    {
        $self = clone $this;
        $self['toMoment'] = $toMoment;

        return $self;
    }

    /**
     * Utilisateur concerné par l'absence.
     * Optionnel si positionTo est fourni (résolu automatiquement).
     */
    public function withUserTo(string $userTo): self
    {
        $self = clone $this;
        $self['userTo'] = $userTo;

        return $self;
    }
}
