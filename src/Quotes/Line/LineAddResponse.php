<?php

declare(strict_types=1);

namespace Wuro\Quotes\Line;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type QuoteLineShape from \Wuro\Quotes\Line\QuoteLine
 * @phpstan-import-type QuoteShape from \Wuro\Quotes\Line\Quote
 *
 * @phpstan-type LineAddResponseShape = array{
 *   line?: null|QuoteLine|QuoteLineShape, updatedQuote?: null|Quote|QuoteShape
 * }
 */
final class LineAddResponse implements BaseModel
{
    /** @use SdkModel<LineAddResponseShape> */
    use SdkModel;

    #[Optional]
    public ?QuoteLine $line;

    #[Optional]
    public ?Quote $updatedQuote;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param QuoteLine|QuoteLineShape|null $line
     * @param Quote|QuoteShape|null $updatedQuote
     */
    public static function with(
        QuoteLine|array|null $line = null,
        Quote|array|null $updatedQuote = null
    ): self {
        $self = new self;

        null !== $line && $self['line'] = $line;
        null !== $updatedQuote && $self['updatedQuote'] = $updatedQuote;

        return $self;
    }

    /**
     * @param QuoteLine|QuoteLineShape $line
     */
    public function withLine(QuoteLine|array $line): self
    {
        $self = clone $this;
        $self['line'] = $line;

        return $self;
    }

    /**
     * @param Quote|QuoteShape $updatedQuote
     */
    public function withUpdatedQuote(Quote|array $updatedQuote): self
    {
        $self = clone $this;
        $self['updatedQuote'] = $updatedQuote;

        return $self;
    }
}
