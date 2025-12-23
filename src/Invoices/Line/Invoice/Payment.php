<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line\Invoice;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type PaymentShape = array{
 *   _id?: string|null,
 *   amount?: float|null,
 *   checkNumber?: string|null,
 *   date?: \DateTimeInterface|null,
 *   methodName?: string|null,
 *   mode?: string|null,
 * }
 */
final class Payment implements BaseModel
{
    /** @use SdkModel<PaymentShape> */
    use SdkModel;

    /**
     * Unique identifier for the payment.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Amount of the payment.
     */
    #[Optional]
    public ?float $amount;

    /**
     * Check number if applicable.
     */
    #[Optional('check_number')]
    public ?string $checkNumber;

    /**
     * Date of the payment.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Name of the payment method.
     */
    #[Optional('method_name')]
    public ?string $methodName;

    /**
     * Reference to the payment method.
     */
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
        ?string $_id = null,
        ?float $amount = null,
        ?string $checkNumber = null,
        ?\DateTimeInterface $date = null,
        ?string $methodName = null,
        ?string $mode = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $amount && $self['amount'] = $amount;
        null !== $checkNumber && $self['checkNumber'] = $checkNumber;
        null !== $date && $self['date'] = $date;
        null !== $methodName && $self['methodName'] = $methodName;
        null !== $mode && $self['mode'] = $mode;

        return $self;
    }

    /**
     * Unique identifier for the payment.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Amount of the payment.
     */
    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * Check number if applicable.
     */
    public function withCheckNumber(string $checkNumber): self
    {
        $self = clone $this;
        $self['checkNumber'] = $checkNumber;

        return $self;
    }

    /**
     * Date of the payment.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Name of the payment method.
     */
    public function withMethodName(string $methodName): self
    {
        $self = clone $this;
        $self['methodName'] = $methodName;

        return $self;
    }

    /**
     * Reference to the payment method.
     */
    public function withMode(string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }
}
