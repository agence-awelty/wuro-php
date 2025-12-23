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
 * @phpstan-type QuoteUpdateResponseShape = array{
 *   updatedQuote?: null|Quote|QuoteShape
 * }
 */
final class QuoteUpdateResponse implements BaseModel
{
    /** @use SdkModel<QuoteUpdateResponseShape> */
    use SdkModel;

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
     * @param Quote|QuoteShape|null $updatedQuote
     */
    public static function with(Quote|array|null $updatedQuote = null): self
    {
        $self = new self;

        null !== $updatedQuote && $self['updatedQuote'] = $updatedQuote;

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
