<?php

declare(strict_types=1);

namespace Wuro\Absences\Absence;

use Wuro\Absences\Absence\Log\StateLog;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type LogShape = array{
 *   comment?: string|null,
 *   date?: \DateTimeInterface|null,
 *   file?: string|null,
 *   fileInSafe?: bool|null,
 *   method?: string|null,
 *   position?: string|null,
 *   state?: string|null,
 *   stateItemRequested?: string|null,
 *   stateLog?: null|StateLog|value-of<StateLog>,
 * }
 */
final class Log implements BaseModel
{
    /** @use SdkModel<LogShape> */
    use SdkModel;

    /**
     * Comment added to the log.
     */
    #[Optional]
    public ?string $comment;

    /**
     * Date of the log.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * File attached to the log.
     */
    #[Optional]
    public ?string $file;

    /**
     * Whether the file is stored in the safe.
     */
    #[Optional]
    public ?bool $fileInSafe;

    /**
     * HTTP method used.
     */
    #[Optional]
    public ?string $method;

    /**
     * Reference to the position.
     */
    #[Optional]
    public ?string $position;

    /**
     * State of the absence at the time of the log.
     */
    #[Optional]
    public ?string $state;

    /**
     * State of the item requested.
     */
    #[Optional]
    public ?string $stateItemRequested;

    /**
     * State of the log.
     *
     * @var value-of<StateLog>|null $stateLog
     */
    #[Optional(enum: StateLog::class)]
    public ?string $stateLog;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param StateLog|value-of<StateLog>|null $stateLog
     */
    public static function with(
        ?string $comment = null,
        ?\DateTimeInterface $date = null,
        ?string $file = null,
        ?bool $fileInSafe = null,
        ?string $method = null,
        ?string $position = null,
        ?string $state = null,
        ?string $stateItemRequested = null,
        StateLog|string|null $stateLog = null,
    ): self {
        $self = new self;

        null !== $comment && $self['comment'] = $comment;
        null !== $date && $self['date'] = $date;
        null !== $file && $self['file'] = $file;
        null !== $fileInSafe && $self['fileInSafe'] = $fileInSafe;
        null !== $method && $self['method'] = $method;
        null !== $position && $self['position'] = $position;
        null !== $state && $self['state'] = $state;
        null !== $stateItemRequested && $self['stateItemRequested'] = $stateItemRequested;
        null !== $stateLog && $self['stateLog'] = $stateLog;

        return $self;
    }

    /**
     * Comment added to the log.
     */
    public function withComment(string $comment): self
    {
        $self = clone $this;
        $self['comment'] = $comment;

        return $self;
    }

    /**
     * Date of the log.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * File attached to the log.
     */
    public function withFile(string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }

    /**
     * Whether the file is stored in the safe.
     */
    public function withFileInSafe(bool $fileInSafe): self
    {
        $self = clone $this;
        $self['fileInSafe'] = $fileInSafe;

        return $self;
    }

    /**
     * HTTP method used.
     */
    public function withMethod(string $method): self
    {
        $self = clone $this;
        $self['method'] = $method;

        return $self;
    }

    /**
     * Reference to the position.
     */
    public function withPosition(string $position): self
    {
        $self = clone $this;
        $self['position'] = $position;

        return $self;
    }

    /**
     * State of the absence at the time of the log.
     */
    public function withState(string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * State of the item requested.
     */
    public function withStateItemRequested(string $stateItemRequested): self
    {
        $self = clone $this;
        $self['stateItemRequested'] = $stateItemRequested;

        return $self;
    }

    /**
     * State of the log.
     *
     * @param StateLog|value-of<StateLog> $stateLog
     */
    public function withStateLog(StateLog|string $stateLog): self
    {
        $self = clone $this;
        $self['stateLog'] = $stateLog;

        return $self;
    }
}
