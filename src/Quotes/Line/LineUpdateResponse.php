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
 * @phpstan-type LineUpdateResponseShape = array{
 *   line?: null|QuoteLine|QuoteLineShape, quote?: null|Quote|QuoteShape
 * }
 */
final class LineUpdateResponse implements BaseModel
{
    /** @use SdkModel<LineUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?QuoteLine $line;

    #[Optional]
    public ?Quote $quote;

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
     * @param Quote|QuoteShape|null $quote
     */
    public static function with(
        QuoteLine|array|null $line = null,
        Quote|array|null $quote = null
    ): self {
        $self = new self;

        null !== $line && $self['line'] = $line;
        null !== $quote && $self['quote'] = $quote;

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
     * @param Quote|QuoteShape $quote
     */
    public function withQuote(Quote|array $quote): self
    {
        $self = clone $this;
        $self['quote'] = $quote;

        return $self;
    }
}
