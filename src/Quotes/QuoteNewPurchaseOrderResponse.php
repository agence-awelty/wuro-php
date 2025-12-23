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
 * @phpstan-type QuoteNewPurchaseOrderResponseShape = array{
 *   newQuote?: null|Quote|QuoteShape
 * }
 */
final class QuoteNewPurchaseOrderResponse implements BaseModel
{
    /** @use SdkModel<QuoteNewPurchaseOrderResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Quote $newQuote;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Quote|QuoteShape|null $newQuote
     */
    public static function with(Quote|array|null $newQuote = null): self
    {
        $self = new self;

        null !== $newQuote && $self['newQuote'] = $newQuote;

        return $self;
    }

    /**
     * @param Quote|QuoteShape $newQuote
     */
    public function withNewQuote(Quote|array $newQuote): self
    {
        $self = clone $this;
        $self['newQuote'] = $newQuote;

        return $self;
    }
}
