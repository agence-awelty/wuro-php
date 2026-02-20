<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Purchases\PurchaseInput\Line;
use Wuro\Purchases\PurchaseInput\Payment;
use Wuro\Purchases\PurchaseInput\State;
use Wuro\Purchases\PurchaseInput\Type;

/**
 * @phpstan-import-type LineShape from \Wuro\Purchases\PurchaseInput\Line
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\PurchaseInput\Payment
 *
 * @phpstan-type PurchaseInputShape = array{
 *   analyticalCode?: string|null,
 *   categories?: list<string>|null,
 *   currency?: string|null,
 *   date?: \DateTimeInterface|null,
 *   invoiceNumber?: string|null,
 *   lines?: list<Line|LineShape>|null,
 *   paymentDate?: \DateTimeInterface|null,
 *   paymentExpiryDate?: \DateTimeInterface|null,
 *   payments?: list<Payment|PaymentShape>|null,
 *   state?: null|State|value-of<State>,
 *   supplier?: string|null,
 *   supplierCode?: string|null,
 *   supplierName?: string|null,
 *   supplierReverseCharge?: bool|null,
 *   supplierTvaNumber?: string|null,
 *   totalHt?: float|null,
 *   totalTtc?: float|null,
 *   totalTva?: float|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class PurchaseInput implements BaseModel
{
    /** @use SdkModel<PurchaseInputShape> */
    use SdkModel;

    #[Optional('analytical_code')]
    public ?string $analyticalCode;

    /** @var list<string>|null $categories */
    #[Optional(list: 'string')]
    public ?array $categories;

    #[Optional]
    public ?string $currency;

    #[Optional]
    public ?\DateTimeInterface $date;

    #[Optional]
    public ?string $invoiceNumber;

    /** @var list<Line>|null $lines */
    #[Optional(list: Line::class)]
    public ?array $lines;

    #[Optional('payment_date')]
    public ?\DateTimeInterface $paymentDate;

    #[Optional('payment_expiry_date')]
    public ?\DateTimeInterface $paymentExpiryDate;

    /** @var list<Payment>|null $payments */
    #[Optional(list: Payment::class)]
    public ?array $payments;

    /** @var value-of<State>|null $state */
    #[Optional(enum: State::class)]
    public ?string $state;

    #[Optional]
    public ?string $supplier;

    #[Optional('supplier_code')]
    public ?string $supplierCode;

    #[Optional('supplier_name')]
    public ?string $supplierName;

    #[Optional]
    public ?bool $supplierReverseCharge;

    #[Optional]
    public ?string $supplierTvaNumber;

    #[Optional('total_ht')]
    public ?float $totalHt;

    #[Optional('total_ttc')]
    public ?float $totalTtc;

    #[Optional('total_tva')]
    public ?float $totalTva;

    /** @var value-of<Type>|null $type */
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
     * @param list<string>|null $categories
     * @param list<Line|LineShape>|null $lines
     * @param list<Payment|PaymentShape>|null $payments
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $analyticalCode = null,
        ?array $categories = null,
        ?string $currency = null,
        ?\DateTimeInterface $date = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        ?\DateTimeInterface $paymentDate = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?array $payments = null,
        State|string|null $state = null,
        ?string $supplier = null,
        ?string $supplierCode = null,
        ?string $supplierName = null,
        ?bool $supplierReverseCharge = null,
        ?string $supplierTvaNumber = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $analyticalCode && $self['analyticalCode'] = $analyticalCode;
        null !== $categories && $self['categories'] = $categories;
        null !== $currency && $self['currency'] = $currency;
        null !== $date && $self['date'] = $date;
        null !== $invoiceNumber && $self['invoiceNumber'] = $invoiceNumber;
        null !== $lines && $self['lines'] = $lines;
        null !== $paymentDate && $self['paymentDate'] = $paymentDate;
        null !== $paymentExpiryDate && $self['paymentExpiryDate'] = $paymentExpiryDate;
        null !== $payments && $self['payments'] = $payments;
        null !== $state && $self['state'] = $state;
        null !== $supplier && $self['supplier'] = $supplier;
        null !== $supplierCode && $self['supplierCode'] = $supplierCode;
        null !== $supplierName && $self['supplierName'] = $supplierName;
        null !== $supplierReverseCharge && $self['supplierReverseCharge'] = $supplierReverseCharge;
        null !== $supplierTvaNumber && $self['supplierTvaNumber'] = $supplierTvaNumber;
        null !== $totalHt && $self['totalHt'] = $totalHt;
        null !== $totalTtc && $self['totalTtc'] = $totalTtc;
        null !== $totalTva && $self['totalTva'] = $totalTva;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    public function withAnalyticalCode(string $analyticalCode): self
    {
        $self = clone $this;
        $self['analyticalCode'] = $analyticalCode;

        return $self;
    }

    /**
     * @param list<string> $categories
     */
    public function withCategories(array $categories): self
    {
        $self = clone $this;
        $self['categories'] = $categories;

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

    public function withInvoiceNumber(string $invoiceNumber): self
    {
        $self = clone $this;
        $self['invoiceNumber'] = $invoiceNumber;

        return $self;
    }

    /**
     * @param list<Line|LineShape> $lines
     */
    public function withLines(array $lines): self
    {
        $self = clone $this;
        $self['lines'] = $lines;

        return $self;
    }

    public function withPaymentDate(\DateTimeInterface $paymentDate): self
    {
        $self = clone $this;
        $self['paymentDate'] = $paymentDate;

        return $self;
    }

    public function withPaymentExpiryDate(
        \DateTimeInterface $paymentExpiryDate
    ): self {
        $self = clone $this;
        $self['paymentExpiryDate'] = $paymentExpiryDate;

        return $self;
    }

    /**
     * @param list<Payment|PaymentShape> $payments
     */
    public function withPayments(array $payments): self
    {
        $self = clone $this;
        $self['payments'] = $payments;

        return $self;
    }

    /**
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    public function withSupplier(string $supplier): self
    {
        $self = clone $this;
        $self['supplier'] = $supplier;

        return $self;
    }

    public function withSupplierCode(string $supplierCode): self
    {
        $self = clone $this;
        $self['supplierCode'] = $supplierCode;

        return $self;
    }

    public function withSupplierName(string $supplierName): self
    {
        $self = clone $this;
        $self['supplierName'] = $supplierName;

        return $self;
    }

    public function withSupplierReverseCharge(bool $supplierReverseCharge): self
    {
        $self = clone $this;
        $self['supplierReverseCharge'] = $supplierReverseCharge;

        return $self;
    }

    public function withSupplierTvaNumber(string $supplierTvaNumber): self
    {
        $self = clone $this;
        $self['supplierTvaNumber'] = $supplierTvaNumber;

        return $self;
    }

    public function withTotalHt(float $totalHt): self
    {
        $self = clone $this;
        $self['totalHt'] = $totalHt;

        return $self;
    }

    public function withTotalTtc(float $totalTtc): self
    {
        $self = clone $this;
        $self['totalTtc'] = $totalTtc;

        return $self;
    }

    public function withTotalTva(float $totalTva): self
    {
        $self = clone $this;
        $self['totalTva'] = $totalTva;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
