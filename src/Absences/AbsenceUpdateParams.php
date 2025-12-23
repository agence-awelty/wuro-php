<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Absences\AbsenceUpdateParams\FromMoment;
use Wuro\Absences\AbsenceUpdateParams\Log;
use Wuro\Absences\AbsenceUpdateParams\State;
use Wuro\Absences\AbsenceUpdateParams\ToMoment;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Met à jour une absence existante.
 *
 * ## Cas d'utilisation courants
 *
 * - **Validation/Refus** : Changer le state vers "accepted" ou "rejected"
 * - **Modification des dates** : Ajuster la période d'absence
 * - **Annulation** : Passer en state "canceled"
 *
 * ## Système de logs
 *
 * Chaque modification est tracée dans l'historique (logs).
 * Vous pouvez ajouter un commentaire et/ou une pièce jointe à chaque action.
 *
 * Les logs enregistrent automatiquement :
 * - La date de l'action
 * - Le poste ayant effectué l'action
 * - La méthode HTTP utilisée
 * - L'état résultant
 *
 * ## Événement déclenché
 *
 * Un événement `UPDATE_ABSENCE` est émis après la mise à jour,
 * permettant de notifier le collaborateur des changements.
 *
 * @see Wuro\Services\AbsencesService::update()
 *
 * @phpstan-import-type LogShape from \Wuro\Absences\AbsenceUpdateParams\Log
 *
 * @phpstan-type AbsenceUpdateParamsShape = array{
 *   from?: \DateTimeInterface|null,
 *   fromMoment?: null|FromMoment|value-of<FromMoment>,
 *   logs?: list<LogShape>|null,
 *   state?: null|State|value-of<State>,
 *   to?: \DateTimeInterface|null,
 *   toMoment?: null|ToMoment|value-of<ToMoment>,
 *   type?: string|null,
 * }
 */
final class AbsenceUpdateParams implements BaseModel
{
    /** @use SdkModel<AbsenceUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Date de début de l'absence.
     */
    #[Optional]
    public ?\DateTimeInterface $from;

    /**
     * Moment de début :
     * - **full** : Journée entière
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     *
     * @var value-of<FromMoment>|null $fromMoment
     */
    #[Optional('from_moment', enum: FromMoment::class)]
    public ?string $fromMoment;

    /**
     * Ajouter des entrées à l'historique de l'absence.
     *
     * @var list<Log>|null $logs
     */
    #[Optional(list: Log::class)]
    public ?array $logs;

    /**
     * Nouvel état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée par le responsable
     * - **rejected** : Refusée par le responsable
     * - **canceled** : Annulée par le collaborateur
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Date de fin de l'absence.
     */
    #[Optional]
    public ?\DateTimeInterface $to;

    /**
     * Moment de fin :
     * - **full** : Journée entière
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     *
     * @var value-of<ToMoment>|null $toMoment
     */
    #[Optional('to_moment', enum: ToMoment::class)]
    public ?string $toMoment;

    /**
     * Référence vers le type d'absence.
     */
    #[Optional]
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
     * @param FromMoment|value-of<FromMoment>|null $fromMoment
     * @param list<LogShape>|null $logs
     * @param State|value-of<State>|null $state
     * @param ToMoment|value-of<ToMoment>|null $toMoment
     */
    public static function with(
        ?\DateTimeInterface $from = null,
        FromMoment|string|null $fromMoment = null,
        ?array $logs = null,
        State|string|null $state = null,
        ?\DateTimeInterface $to = null,
        ToMoment|string|null $toMoment = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $from && $self['from'] = $from;
        null !== $fromMoment && $self['fromMoment'] = $fromMoment;
        null !== $logs && $self['logs'] = $logs;
        null !== $state && $self['state'] = $state;
        null !== $to && $self['to'] = $to;
        null !== $toMoment && $self['toMoment'] = $toMoment;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Date de début de l'absence.
     */
    public function withFrom(\DateTimeInterface $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Moment de début :
     * - **full** : Journée entière
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
     * Ajouter des entrées à l'historique de l'absence.
     *
     * @param list<LogShape> $logs
     */
    public function withLogs(array $logs): self
    {
        $self = clone $this;
        $self['logs'] = $logs;

        return $self;
    }

    /**
     * Nouvel état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée par le responsable
     * - **rejected** : Refusée par le responsable
     * - **canceled** : Annulée par le collaborateur
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
     * Date de fin de l'absence.
     */
    public function withTo(\DateTimeInterface $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Moment de fin :
     * - **full** : Journée entière
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
     * Référence vers le type d'absence.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
