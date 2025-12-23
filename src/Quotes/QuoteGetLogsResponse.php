<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type QuoteGetLogsResponseShape = array{
 *   logs?: list<mixed>|null, total?: int|null
 * }
 */
final class QuoteGetLogsResponse implements BaseModel
{
    /** @use SdkModel<QuoteGetLogsResponseShape> */
    use SdkModel;

    /** @var list<mixed>|null $logs */
    #[Optional(list: 'mixed')]
    public ?array $logs;

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
     * @param list<mixed>|null $logs
     */
    public static function with(?array $logs = null, ?int $total = null): self
    {
        $self = new self;

        null !== $logs && $self['logs'] = $logs;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * @param list<mixed> $logs
     */
    public function withLogs(array $logs): self
    {
        $self = clone $this;
        $self['logs'] = $logs;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
