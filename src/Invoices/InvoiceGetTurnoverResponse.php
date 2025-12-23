<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceGetTurnoverResponseShape = array{turnover?: float|null}
 */
final class InvoiceGetTurnoverResponse implements BaseModel
{
    /** @use SdkModel<InvoiceGetTurnoverResponseShape> */
    use SdkModel;

    /**
     * Chiffre d'affaires total.
     */
    #[Optional]
    public ?float $turnover;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?float $turnover = null): self
    {
        $self = new self;

        null !== $turnover && $self['turnover'] = $turnover;

        return $self;
    }

    /**
     * Chiffre d'affaires total.
     */
    public function withTurnover(float $turnover): self
    {
        $self = clone $this;
        $self['turnover'] = $turnover;

        return $self;
    }
}
