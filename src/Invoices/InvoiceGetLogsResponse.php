<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceGetLogsResponseShape = array{
 *   limit?: int|null, logs?: list<mixed>|null, skip?: int|null, total?: int|null
 * }
 */
final class InvoiceGetLogsResponse implements BaseModel
{
    /** @use SdkModel<InvoiceGetLogsResponseShape> */
    use SdkModel;

    #[Optional]
    public ?int $limit;

    /** @var list<mixed>|null $logs */
    #[Optional(list: 'mixed')]
    public ?array $logs;

    #[Optional]
    public ?int $skip;

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
    public static function with(
        ?int $limit = null,
        ?array $logs = null,
        ?int $skip = null,
        ?int $total = null
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $logs && $self['logs'] = $logs;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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

    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
