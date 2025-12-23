<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Quotes\Line\Quote;

/**
 * @phpstan-import-type QuoteShape from \Wuro\Quotes\Line\Quote
 *
 * @phpstan-type QuoteListResponseShape = array{
 *   limit?: int|null,
 *   quotes?: list<QuoteShape>|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class QuoteListResponse implements BaseModel
{
    /** @use SdkModel<QuoteListResponseShape> */
    use SdkModel;

    #[Optional]
    public ?int $limit;

    /** @var list<Quote>|null $quotes */
    #[Optional(list: Quote::class)]
    public ?array $quotes;

    #[Optional]
    public ?int $skip;

    /**
     * Nombre total de devis.
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
     * @param list<QuoteShape>|null $quotes
     */
    public static function with(
        ?int $limit = null,
        ?array $quotes = null,
        ?int $skip = null,
        ?int $total = null
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $quotes && $self['quotes'] = $quotes;
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
     * @param list<QuoteShape> $quotes
     */
    public function withQuotes(array $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Nombre total de devis.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
