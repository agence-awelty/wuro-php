<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Quotes\QuoteGetResponse\Quote;

/**
 * @phpstan-import-type QuoteShape from \Wuro\Quotes\QuoteGetResponse\Quote
 *
 * @phpstan-type QuoteGetResponseShape = array{quote?: null|Quote|QuoteShape}
 */
final class QuoteGetResponse implements BaseModel
{
    /** @use SdkModel<QuoteGetResponseShape> */
    use SdkModel;

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
     * @param Quote|QuoteShape|null $quote
     */
    public static function with(Quote|array|null $quote = null): self
    {
        $self = new self;

        null !== $quote && $self['quote'] = $quote;

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
