<?php

declare(strict_types=1);

namespace Wuro\Quotes\Line\Quote;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Quotes\Line\Quote\Acompte\Type;

/**
 * @phpstan-type AcompteShape = array{
 *   _id?: string|null,
 *   amount?: float|null,
 *   amountHt?: float|null,
 *   credit?: bool|null,
 *   date?: \DateTimeInterface|null,
 *   number?: string|null,
 *   sold?: bool|null,
 *   type?: null|\Wuro\Quotes\Line\Quote\Acompte\Type|value-of<\Wuro\Quotes\Line\Quote\Acompte\Type>,
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

    /**
     * If it's a credit note.
     */
    #[Optional]
    public ?bool $credit;

    #[Optional]
    public ?\DateTimeInterface $date;

    #[Optional]
    public ?string $number;

    #[Optional]
    public ?bool $sold;

    /**
     * Type of payment.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $_id = null,
        ?float $amount = null,
        ?float $amountHt = null,
        ?bool $credit = null,
        ?\DateTimeInterface $date = null,
        ?string $number = null,
        ?bool $sold = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $amount && $self['amount'] = $amount;
        null !== $amountHt && $self['amountHt'] = $amountHt;
        null !== $credit && $self['credit'] = $credit;
        null !== $date && $self['date'] = $date;
        null !== $number && $self['number'] = $number;
        null !== $sold && $self['sold'] = $sold;
        null !== $type && $self['type'] = $type;

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

    /**
     * If it's a credit note.
     */
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

    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    public function withSold(bool $sold): self
    {
        $self = clone $this;
        $self['sold'] = $sold;

        return $self;
    }

    /**
     * Type of payment.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(
        Type|string $type
    ): self {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
