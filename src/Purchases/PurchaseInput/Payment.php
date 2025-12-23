<?php

declare(strict_types=1);

namespace Wuro\Purchases\PurchaseInput;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type PaymentShape = array{
 *   amount?: float|null, date?: \DateTimeInterface|null, mode?: string|null
 * }
 */
final class Payment implements BaseModel
{
    /** @use SdkModel<PaymentShape> */
    use SdkModel;

    #[Optional]
    public ?float $amount;

    #[Optional]
    public ?\DateTimeInterface $date;

    #[Optional]
    public ?string $mode;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?float $amount = null,
        ?\DateTimeInterface $date = null,
        ?string $mode = null
    ): self {
        $self = new self;

        null !== $amount && $self['amount'] = $amount;
        null !== $date && $self['date'] = $date;
        null !== $mode && $self['mode'] = $mode;

        return $self;
    }

    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    public function withMode(string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }
}
