<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Absences\Absence\FromMoment;
use Wuro\Absences\Absence\Log;
use Wuro\Absences\Absence\Period;
use Wuro\Absences\Absence\State;
use Wuro\Absences\Absence\ToMoment;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type LogShape from \Wuro\Absences\Absence\Log
 *
 * @phpstan-type AbsenceShape = array{
 *   _id?: string|null,
 *   company?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   decisionDate?: \DateTimeInterface|null,
 *   from?: \DateTimeInterface|null,
 *   fromMoment?: null|FromMoment|value-of<FromMoment>,
 *   logs?: list<LogShape>|null,
 *   nbDays?: float|null,
 *   period?: null|Period|value-of<Period>,
 *   positionDecider?: string|null,
 *   positionFirstName?: string|null,
 *   positionFrom?: string|null,
 *   positionLastName?: string|null,
 *   positionTo?: string|null,
 *   state?: null|State|value-of<State>,
 *   timezone?: string|null,
 *   to?: \DateTimeInterface|null,
 *   toMoment?: null|ToMoment|value-of<ToMoment>,
 *   type?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   userTo?: string|null,
 * }
 */
final class Absence implements BaseModel
{
    /** @use SdkModel<AbsenceShape> */
    use SdkModel;

    /**
     * Unique identifier for the absence.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Date when the absence was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Date when the state was changed.
     */
    #[Optional('decision_date')]
    public ?\DateTimeInterface $decisionDate;

    /**
     * Start date of the absence.
     */
    #[Optional]
    public ?\DateTimeInterface $from;

    /**
     * Moment of the day when the absence starts.
     *
     * @var value-of<FromMoment>|null $fromMoment
     */
    #[Optional('from_moment', enum: FromMoment::class)]
    public ?string $fromMoment;

    /**
     * List of logs for the absence.
     *
     * @var list<Log>|null $logs
     */
    #[Optional(list: Log::class)]
    public ?array $logs;

    /**
     * Number of days of absence.
     */
    #[Optional]
    public ?float $nbDays;

    /**
     * Period type of the absence.
     *
     * @var value-of<Period>|null $period
     */
    #[Optional(enum: Period::class)]
    public ?string $period;

    /**
     * Reference to the position that made the decision.
     */
    #[Optional]
    public ?string $positionDecider;

    /**
     * First name of the position for search purposes.
     */
    #[Optional]
    public ?string $positionFirstName;

    /**
     * Reference to the position that created the absence.
     */
    #[Optional]
    public ?string $positionFrom;

    /**
     * Last name of the position for search purposes.
     */
    #[Optional]
    public ?string $positionLastName;

    /**
     * Reference to the position for which the absence is created.
     */
    #[Optional]
    public ?string $positionTo;

    /**
     * State of the absence.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Timezone for the absence dates.
     */
    #[Optional]
    public ?string $timezone;

    /**
     * End date of the absence.
     */
    #[Optional]
    public ?\DateTimeInterface $to;

    /**
     * Moment of the day when the absence ends.
     *
     * @var value-of<ToMoment>|null $toMoment
     */
    #[Optional('to_moment', enum: ToMoment::class)]
    public ?string $toMoment;

    /**
     * Reference to the absence type.
     */
    #[Optional]
    public ?string $type;

    /**
     * Date when the absence was last updated.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Reference to the user for which the absence is created.
     */
    #[Optional]
    public ?string $userTo;

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
     * @param Period|value-of<Period>|null $period
     * @param State|value-of<State>|null $state
     * @param ToMoment|value-of<ToMoment>|null $toMoment
     */
    public static function with(
        ?string $_id = null,
        ?string $company = null,
        ?\DateTimeInterface $createdAt = null,
        ?\DateTimeInterface $decisionDate = null,
        ?\DateTimeInterface $from = null,
        FromMoment|string|null $fromMoment = null,
        ?array $logs = null,
        ?float $nbDays = null,
        Period|string|null $period = null,
        ?string $positionDecider = null,
        ?string $positionFirstName = null,
        ?string $positionFrom = null,
        ?string $positionLastName = null,
        ?string $positionTo = null,
        State|string|null $state = null,
        ?string $timezone = null,
        ?\DateTimeInterface $to = null,
        ToMoment|string|null $toMoment = null,
        ?string $type = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $userTo = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $company && $self['company'] = $company;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $decisionDate && $self['decisionDate'] = $decisionDate;
        null !== $from && $self['from'] = $from;
        null !== $fromMoment && $self['fromMoment'] = $fromMoment;
        null !== $logs && $self['logs'] = $logs;
        null !== $nbDays && $self['nbDays'] = $nbDays;
        null !== $period && $self['period'] = $period;
        null !== $positionDecider && $self['positionDecider'] = $positionDecider;
        null !== $positionFirstName && $self['positionFirstName'] = $positionFirstName;
        null !== $positionFrom && $self['positionFrom'] = $positionFrom;
        null !== $positionLastName && $self['positionLastName'] = $positionLastName;
        null !== $positionTo && $self['positionTo'] = $positionTo;
        null !== $state && $self['state'] = $state;
        null !== $timezone && $self['timezone'] = $timezone;
        null !== $to && $self['to'] = $to;
        null !== $toMoment && $self['toMoment'] = $toMoment;
        null !== $type && $self['type'] = $type;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $userTo && $self['userTo'] = $userTo;

        return $self;
    }

    /**
     * Unique identifier for the absence.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Reference to the company.
     */
    public function withCompany(string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    /**
     * Date when the absence was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Date when the state was changed.
     */
    public function withDecisionDate(\DateTimeInterface $decisionDate): self
    {
        $self = clone $this;
        $self['decisionDate'] = $decisionDate;

        return $self;
    }

    /**
     * Start date of the absence.
     */
    public function withFrom(\DateTimeInterface $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Moment of the day when the absence starts.
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
     * List of logs for the absence.
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
     * Number of days of absence.
     */
    public function withNbDays(float $nbDays): self
    {
        $self = clone $this;
        $self['nbDays'] = $nbDays;

        return $self;
    }

    /**
     * Period type of the absence.
     *
     * @param Period|value-of<Period> $period
     */
    public function withPeriod(Period|string $period): self
    {
        $self = clone $this;
        $self['period'] = $period;

        return $self;
    }

    /**
     * Reference to the position that made the decision.
     */
    public function withPositionDecider(string $positionDecider): self
    {
        $self = clone $this;
        $self['positionDecider'] = $positionDecider;

        return $self;
    }

    /**
     * First name of the position for search purposes.
     */
    public function withPositionFirstName(string $positionFirstName): self
    {
        $self = clone $this;
        $self['positionFirstName'] = $positionFirstName;

        return $self;
    }

    /**
     * Reference to the position that created the absence.
     */
    public function withPositionFrom(string $positionFrom): self
    {
        $self = clone $this;
        $self['positionFrom'] = $positionFrom;

        return $self;
    }

    /**
     * Last name of the position for search purposes.
     */
    public function withPositionLastName(string $positionLastName): self
    {
        $self = clone $this;
        $self['positionLastName'] = $positionLastName;

        return $self;
    }

    /**
     * Reference to the position for which the absence is created.
     */
    public function withPositionTo(string $positionTo): self
    {
        $self = clone $this;
        $self['positionTo'] = $positionTo;

        return $self;
    }

    /**
     * State of the absence.
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
     * Timezone for the absence dates.
     */
    public function withTimezone(string $timezone): self
    {
        $self = clone $this;
        $self['timezone'] = $timezone;

        return $self;
    }

    /**
     * End date of the absence.
     */
    public function withTo(\DateTimeInterface $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Moment of the day when the absence ends.
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
     * Reference to the absence type.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Date when the absence was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Reference to the user for which the absence is created.
     */
    public function withUserTo(string $userTo): self
    {
        $self = clone $this;
        $self['userTo'] = $userTo;

        return $self;
    }
}
