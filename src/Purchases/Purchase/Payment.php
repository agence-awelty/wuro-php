<?php

declare(strict_types=1);

namespace Wuro\Purchases\Purchase;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type PaymentShape = array{
 *   amount?: float|null,
 *   checkNumber?: string|null,
 *   currency?: string|null,
 *   date?: \DateTimeInterface|null,
 *   methodName?: string|null,
 *   mode?: string|null,
 * }
 */
final class Payment implements BaseModel
{
    /** @use SdkModel<PaymentShape> */
    use SdkModel;

    #[Optional]
    public ?float $amount;

    #[Optional('check_number')]
    public ?string $checkNumber;

    #[Optional]
    public ?string $currency;

    #[Optional]
    public ?\DateTimeInterface $date;

    #[Optional('method_name')]
    public ?string $methodName;

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
        ?string $checkNumber = null,
        ?string $currency = null,
        ?\DateTimeInterface $date = null,
        ?string $methodName = null,
        ?string $mode = null,
    ): self {
        $self = new self;

        null !== $amount && $self['amount'] = $amount;
        null !== $checkNumber && $self['checkNumber'] = $checkNumber;
        null !== $currency && $self['currency'] = $currency;
        null !== $date && $self['date'] = $date;
        null !== $methodName && $self['methodName'] = $methodName;
        null !== $mode && $self['mode'] = $mode;

        return $self;
    }

    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    public function withCheckNumber(string $checkNumber): self
    {
        $self = clone $this;
        $self['checkNumber'] = $checkNumber;

        return $self;
    }

    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    public function withMethodName(string $methodName): self
    {
        $self = clone $this;
        $self['methodName'] = $methodName;

        return $self;
    }

    public function withMode(string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }
}
