<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\Line\VatRate;
use Wuro\Purchases\Purchase\BankReconciliationStatus;
use Wuro\Purchases\Purchase\Line;
use Wuro\Purchases\Purchase\Payment;
use Wuro\Purchases\Purchase\State;
use Wuro\Purchases\Purchase\Type;

/**
 * @phpstan-import-type LineShape from \Wuro\Purchases\Purchase\Line
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\Purchase\Payment
 * @phpstan-import-type VatRateShape from \Wuro\Invoices\Line\VatRate
 *
 * @phpstan-type PurchaseShape = array{
 *   _id?: string|null,
 *   analyticalCode?: string|null,
 *   bankReconciliateTotal?: float|null,
 *   bankReconciliationStatus?: null|BankReconciliationStatus|value-of<BankReconciliationStatus>,
 *   bankReconciliations?: list<string>|null,
 *   baseCurrency?: string|null,
 *   categories?: list<string>|null,
 *   company?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   creditForPurchase?: string|null,
 *   currency?: string|null,
 *   date?: \DateTimeInterface|null,
 *   dateRecord?: \DateTimeInterface|null,
 *   exported?: bool|null,
 *   exportedFec?: bool|null,
 *   exportedPdf?: bool|null,
 *   invoiceNumber?: string|null,
 *   lines?: list<LineShape>|null,
 *   number?: string|null,
 *   paymentDate?: \DateTimeInterface|null,
 *   paymentExpiryDate?: \DateTimeInterface|null,
 *   paymentMethods?: list<string>|null,
 *   payments?: list<PaymentShape>|null,
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
 *   updatedAt?: \DateTimeInterface|null,
 *   url?: string|null,
 *   vatRates?: list<VatRateShape>|null,
 * }
 */
final class Purchase implements BaseModel
{
    /** @use SdkModel<PurchaseShape> */
    use SdkModel;

    /**
     * Unique identifier for the purchase.
     */
    #[Optional]
    public ?string $_id;

    #[Optional('analytical_code')]
    public ?string $analyticalCode;

    #[Optional('bank_reconciliate_total')]
    public ?float $bankReconciliateTotal;

    /** @var value-of<BankReconciliationStatus>|null $bankReconciliationStatus */
    #[Optional(
        'bank_reconciliation_status',
        enum: BankReconciliationStatus::class
    )]
    public ?string $bankReconciliationStatus;

    /** @var list<string>|null $bankReconciliations */
    #[Optional('bank_reconciliations', list: 'string')]
    public ?array $bankReconciliations;

    #[Optional('base_currency')]
    public ?string $baseCurrency;

    /**
     * Purchase category references.
     *
     * @var list<string>|null $categories
     */
    #[Optional(list: 'string')]
    public ?array $categories;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Reference to original purchase for credit notes.
     */
    #[Optional]
    public ?string $creditForPurchase;

    #[Optional]
    public ?string $currency;

    /**
     * Purchase date.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Record date.
     */
    #[Optional]
    public ?\DateTimeInterface $dateRecord;

    #[Optional]
    public ?bool $exported;

    #[Optional('exportedFEC')]
    public ?bool $exportedFec;

    #[Optional('exportedPDF')]
    public ?bool $exportedPdf;

    /**
     * Supplier invoice number.
     */
    #[Optional]
    public ?string $invoiceNumber;

    /** @var list<Line>|null $lines */
    #[Optional(list: Line::class)]
    public ?array $lines;

    /**
     * Purchase number.
     */
    #[Optional]
    public ?string $number;

    #[Optional('payment_date')]
    public ?\DateTimeInterface $paymentDate;

    #[Optional('payment_expiry_date')]
    public ?\DateTimeInterface $paymentExpiryDate;

    /** @var list<string>|null $paymentMethods */
    #[Optional('payment_methods', list: 'string')]
    public ?array $paymentMethods;

    /** @var list<Payment>|null $payments */
    #[Optional(list: Payment::class)]
    public ?array $payments;

    /** @var value-of<State>|null $state */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Reference to supplier (client).
     */
    #[Optional]
    public ?string $supplier;

    /**
     * Supplier code.
     */
    #[Optional('supplier_code')]
    public ?string $supplierCode;

    /**
     * Supplier name.
     */
    #[Optional('supplier_name')]
    public ?string $supplierName;

    /**
     * Reverse charge applicable.
     */
    #[Optional]
    public ?bool $supplierReverseCharge;

    /**
     * Supplier VAT number.
     */
    #[Optional]
    public ?string $supplierTvaNumber;

    /**
     * Total without tax.
     */
    #[Optional('total_ht')]
    public ?float $totalHt;

    /**
     * Total with tax.
     */
    #[Optional('total_ttc')]
    public ?float $totalTtc;

    /**
     * Total VAT amount.
     */
    #[Optional('total_tva')]
    public ?float $totalTva;

    /** @var value-of<Type>|null $type */
    #[Optional(enum: Type::class)]
    public ?string $type;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Attached file URL.
     */
    #[Optional]
    public ?string $url;

    /** @var list<VatRate>|null $vatRates */
    #[Optional('VatRates', list: VatRate::class)]
    public ?array $vatRates;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BankReconciliationStatus|value-of<BankReconciliationStatus>|null $bankReconciliationStatus
     * @param list<string>|null $bankReconciliations
     * @param list<string>|null $categories
     * @param list<LineShape>|null $lines
     * @param list<string>|null $paymentMethods
     * @param list<PaymentShape>|null $payments
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     * @param list<VatRateShape>|null $vatRates
     */
    public static function with(
        ?string $_id = null,
        ?string $analyticalCode = null,
        ?float $bankReconciliateTotal = null,
        BankReconciliationStatus|string|null $bankReconciliationStatus = null,
        ?array $bankReconciliations = null,
        ?string $baseCurrency = null,
        ?array $categories = null,
        ?string $company = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $creditForPurchase = null,
        ?string $currency = null,
        ?\DateTimeInterface $date = null,
        ?\DateTimeInterface $dateRecord = null,
        ?bool $exported = null,
        ?bool $exportedFec = null,
        ?bool $exportedPdf = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        ?string $number = null,
        ?\DateTimeInterface $paymentDate = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?array $paymentMethods = null,
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
        ?\DateTimeInterface $updatedAt = null,
        ?string $url = null,
        ?array $vatRates = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $analyticalCode && $self['analyticalCode'] = $analyticalCode;
        null !== $bankReconciliateTotal && $self['bankReconciliateTotal'] = $bankReconciliateTotal;
        null !== $bankReconciliationStatus && $self['bankReconciliationStatus'] = $bankReconciliationStatus;
        null !== $bankReconciliations && $self['bankReconciliations'] = $bankReconciliations;
        null !== $baseCurrency && $self['baseCurrency'] = $baseCurrency;
        null !== $categories && $self['categories'] = $categories;
        null !== $company && $self['company'] = $company;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $creditForPurchase && $self['creditForPurchase'] = $creditForPurchase;
        null !== $currency && $self['currency'] = $currency;
        null !== $date && $self['date'] = $date;
        null !== $dateRecord && $self['dateRecord'] = $dateRecord;
        null !== $exported && $self['exported'] = $exported;
        null !== $exportedFec && $self['exportedFec'] = $exportedFec;
        null !== $exportedPdf && $self['exportedPdf'] = $exportedPdf;
        null !== $invoiceNumber && $self['invoiceNumber'] = $invoiceNumber;
        null !== $lines && $self['lines'] = $lines;
        null !== $number && $self['number'] = $number;
        null !== $paymentDate && $self['paymentDate'] = $paymentDate;
        null !== $paymentExpiryDate && $self['paymentExpiryDate'] = $paymentExpiryDate;
        null !== $paymentMethods && $self['paymentMethods'] = $paymentMethods;
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
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $url && $self['url'] = $url;
        null !== $vatRates && $self['vatRates'] = $vatRates;

        return $self;
    }

    /**
     * Unique identifier for the purchase.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    public function withAnalyticalCode(string $analyticalCode): self
    {
        $self = clone $this;
        $self['analyticalCode'] = $analyticalCode;

        return $self;
    }

    public function withBankReconciliateTotal(
        float $bankReconciliateTotal
    ): self {
        $self = clone $this;
        $self['bankReconciliateTotal'] = $bankReconciliateTotal;

        return $self;
    }

    /**
     * @param BankReconciliationStatus|value-of<BankReconciliationStatus> $bankReconciliationStatus
     */
    public function withBankReconciliationStatus(
        BankReconciliationStatus|string $bankReconciliationStatus
    ): self {
        $self = clone $this;
        $self['bankReconciliationStatus'] = $bankReconciliationStatus;

        return $self;
    }

    /**
     * @param list<string> $bankReconciliations
     */
    public function withBankReconciliations(array $bankReconciliations): self
    {
        $self = clone $this;
        $self['bankReconciliations'] = $bankReconciliations;

        return $self;
    }

    public function withBaseCurrency(string $baseCurrency): self
    {
        $self = clone $this;
        $self['baseCurrency'] = $baseCurrency;

        return $self;
    }

    /**
     * Purchase category references.
     *
     * @param list<string> $categories
     */
    public function withCategories(array $categories): self
    {
        $self = clone $this;
        $self['categories'] = $categories;

        return $self;
    }

    /**
     * Reference to the company.
     */
    public function withCompany(string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Reference to original purchase for credit notes.
     */
    public function withCreditForPurchase(string $creditForPurchase): self
    {
        $self = clone $this;
        $self['creditForPurchase'] = $creditForPurchase;

        return $self;
    }

    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Purchase date.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Record date.
     */
    public function withDateRecord(\DateTimeInterface $dateRecord): self
    {
        $self = clone $this;
        $self['dateRecord'] = $dateRecord;

        return $self;
    }

    public function withExported(bool $exported): self
    {
        $self = clone $this;
        $self['exported'] = $exported;

        return $self;
    }

    public function withExportedFec(bool $exportedFec): self
    {
        $self = clone $this;
        $self['exportedFec'] = $exportedFec;

        return $self;
    }

    public function withExportedPdf(bool $exportedPdf): self
    {
        $self = clone $this;
        $self['exportedPdf'] = $exportedPdf;

        return $self;
    }

    /**
     * Supplier invoice number.
     */
    public function withInvoiceNumber(string $invoiceNumber): self
    {
        $self = clone $this;
        $self['invoiceNumber'] = $invoiceNumber;

        return $self;
    }

    /**
     * @param list<LineShape> $lines
     */
    public function withLines(array $lines): self
    {
        $self = clone $this;
        $self['lines'] = $lines;

        return $self;
    }

    /**
     * Purchase number.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

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
     * @param list<string> $paymentMethods
     */
    public function withPaymentMethods(array $paymentMethods): self
    {
        $self = clone $this;
        $self['paymentMethods'] = $paymentMethods;

        return $self;
    }

    /**
     * @param list<PaymentShape> $payments
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

    /**
     * Reference to supplier (client).
     */
    public function withSupplier(string $supplier): self
    {
        $self = clone $this;
        $self['supplier'] = $supplier;

        return $self;
    }

    /**
     * Supplier code.
     */
    public function withSupplierCode(string $supplierCode): self
    {
        $self = clone $this;
        $self['supplierCode'] = $supplierCode;

        return $self;
    }

    /**
     * Supplier name.
     */
    public function withSupplierName(string $supplierName): self
    {
        $self = clone $this;
        $self['supplierName'] = $supplierName;

        return $self;
    }

    /**
     * Reverse charge applicable.
     */
    public function withSupplierReverseCharge(bool $supplierReverseCharge): self
    {
        $self = clone $this;
        $self['supplierReverseCharge'] = $supplierReverseCharge;

        return $self;
    }

    /**
     * Supplier VAT number.
     */
    public function withSupplierTvaNumber(string $supplierTvaNumber): self
    {
        $self = clone $this;
        $self['supplierTvaNumber'] = $supplierTvaNumber;

        return $self;
    }

    /**
     * Total without tax.
     */
    public function withTotalHt(float $totalHt): self
    {
        $self = clone $this;
        $self['totalHt'] = $totalHt;

        return $self;
    }

    /**
     * Total with tax.
     */
    public function withTotalTtc(float $totalTtc): self
    {
        $self = clone $this;
        $self['totalTtc'] = $totalTtc;

        return $self;
    }

    /**
     * Total VAT amount.
     */
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

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Attached file URL.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * @param list<VatRateShape> $vatRates
     */
    public function withVatRates(array $vatRates): self
    {
        $self = clone $this;
        $self['vatRates'] = $vatRates;

        return $self;
    }
}
