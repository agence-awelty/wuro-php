<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line\Invoice;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type AcompteShape = array{
 *   _id?: string|null,
 *   amount?: float|null,
 *   amountHt?: float|null,
 *   credit?: bool|null,
 *   date?: \DateTimeInterface|null,
 * }
 */
final class Acompte implements BaseModel
{
    /** @use SdkModel<AcompteShape> */
    use SdkModel;

    #[Optional]
    public ?string $_id;

    /**
     * Amount of the advance payment.
     */
    #[Optional]
    public ?float $amount;

    /**
     * Amount without tax.
     */
    #[Optional('amount_ht')]
    public ?float $amountHt;

    #[Optional]
    public ?bool $credit;

    #[Optional]
    public ?\DateTimeInterface $date;

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
        ?float $amountHt = null,
        ?bool $credit = null,
        ?\DateTimeInterface $date = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $amount && $self['amount'] = $amount;
        null !== $amountHt && $self['amountHt'] = $amountHt;
        null !== $credit && $self['credit'] = $credit;
        null !== $date && $self['date'] = $date;

        return $self;
    }

    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Amount of the advance payment.
     */
    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * Amount without tax.
     */
    public function withAmountHt(float $amountHt): self
    {
        $self = clone $this;
        $self['amountHt'] = $amountHt;

        return $self;
    }

    public function withCredit(bool $credit): self
    {
        $self = clone $this;
        $self['credit'] = $credit;

        return $self;
    }

    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }
}
