<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceNewResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\Line\Invoice\Acompte;
use Wuro\Invoices\Line\Invoice\Payment;
use Wuro\Invoices\Line\Invoice\State;
use Wuro\Invoices\Line\Invoice\Type;
use Wuro\Invoices\Line\InvoiceLine;
use Wuro\Invoices\Line\VatRate;

/**
 * @phpstan-import-type AcompteShape from \Wuro\Invoices\Line\Invoice\Acompte
 * @phpstan-import-type InvoiceLineShape from \Wuro\Invoices\Line\InvoiceLine
 * @phpstan-import-type PaymentShape from \Wuro\Invoices\Line\Invoice\Payment
 * @phpstan-import-type VatRateShape from \Wuro\Invoices\Line\VatRate
 *
 * @phpstan-type NewInvoiceShape = array{
 *   _id?: string|null,
 *   acomptes?: list<AcompteShape>|null,
 *   baseCurrency?: string|null,
 *   client?: string|null,
 *   clientAddress?: string|null,
 *   clientCity?: string|null,
 *   clientCountry?: string|null,
 *   clientEmail?: string|null,
 *   clientName?: string|null,
 *   clientPhone?: string|null,
 *   clientZipCode?: string|null,
 *   company?: string|null,
 *   companyName?: string|null,
 *   date?: \DateTimeInterface|null,
 *   invoiceLines?: list<InvoiceLineShape>|null,
 *   number?: string|null,
 *   paymentExpiryDate?: \DateTimeInterface|null,
 *   payments?: list<PaymentShape>|null,
 *   state?: null|State|value-of<State>,
 *   title?: string|null,
 *   totalHt?: float|null,
 *   totalTtc?: float|null,
 *   totalTva?: float|null,
 *   type?: null|Type|value-of<Type>,
 *   vatRates?: list<VatRateShape>|null,
 *   htmlLink?: string|null,
 *   pdfLink?: string|null,
 * }
 */
final class NewInvoice implements BaseModel
{
    /** @use SdkModel<NewInvoiceShape> */
    use SdkModel;

    /**
     * Unique identifier for the invoice.
     */
    #[Optional]
    public ?string $_id;

    /**
     * List of advance payments.
     *
     * @var list<Acompte>|null $acomptes
     */
    #[Optional(list: Acompte::class)]
    public ?array $acomptes;

    /**
     * The currency with which the company works for this invoice.
     */
    #[Optional('base_currency')]
    public ?string $baseCurrency;

    /**
     * Reference to the client.
     */
    #[Optional]
    public ?string $client;

    /**
     * Address of the client.
     */
    #[Optional('client_address')]
    public ?string $clientAddress;

    /**
     * City of the client.
     */
    #[Optional('client_city')]
    public ?string $clientCity;

    /**
     * Country of the client.
     */
    #[Optional('client_country')]
    public ?string $clientCountry;

    /**
     * Email of the client.
     */
    #[Optional('client_email')]
    public ?string $clientEmail;

    /**
     * Name of the client.
     */
    #[Optional('client_name')]
    public ?string $clientName;

    /**
     * Phone number of the client.
     */
    #[Optional('client_phone')]
    public ?string $clientPhone;

    /**
     * Zip code of the client.
     */
    #[Optional('client_zip_code')]
    public ?string $clientZipCode;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Name of the company.
     */
    #[Optional('company_name')]
    public ?string $companyName;

    /**
     * Date of the invoice.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * List of invoice lines.
     *
     * @var list<InvoiceLine>|null $invoiceLines
     */
    #[Optional('invoice_lines', list: InvoiceLine::class)]
    public ?array $invoiceLines;

    /**
     * Invoice number.
     */
    #[Optional]
    public ?string $number;

    /**
     * Expiry date for payment.
     */
    #[Optional('payment_expiry_date')]
    public ?\DateTimeInterface $paymentExpiryDate;

    /**
     * List of payments.
     *
     * @var list<Payment>|null $payments
     */
    #[Optional(list: Payment::class)]
    public ?array $payments;

    /**
     * State of the invoice.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Short description or label of the invoice.
     */
    #[Optional]
    public ?string $title;

    /**
     * Total amount without tax.
     */
    #[Optional('total_ht')]
    public ?float $totalHt;

    /**
     * Total amount with tax.
     */
    #[Optional('total_ttc')]
    public ?float $totalTtc;

    /**
     * Total tax amount.
     */
    #[Optional('total_tva')]
    public ?float $totalTva;

    /**
     * Type of the invoice.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * List of VAT rates applied to the invoice.
     *
     * @var list<VatRate>|null $vatRates
     */
    #[Optional('VATRates', list: VatRate::class)]
    public ?array $vatRates;

    /**
     * Lien vers la version HTML.
     */
    #[Optional('html_link')]
    public ?string $htmlLink;

    /**
     * Lien vers le PDF.
     */
    #[Optional('pdf_link')]
    public ?string $pdfLink;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AcompteShape>|null $acomptes
     * @param list<InvoiceLineShape>|null $invoiceLines
     * @param list<PaymentShape>|null $payments
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     * @param list<VatRateShape>|null $vatRates
     */
    public static function with(
        ?string $_id = null,
        ?array $acomptes = null,
        ?string $baseCurrency = null,
        ?string $client = null,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        ?string $clientCountry = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientPhone = null,
        ?string $clientZipCode = null,
        ?string $company = null,
        ?string $companyName = null,
        ?\DateTimeInterface $date = null,
        ?array $invoiceLines = null,
        ?string $number = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?array $payments = null,
        State|string|null $state = null,
        ?string $title = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        Type|string|null $type = null,
        ?array $vatRates = null,
        ?string $htmlLink = null,
        ?string $pdfLink = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $acomptes && $self['acomptes'] = $acomptes;
        null !== $baseCurrency && $self['baseCurrency'] = $baseCurrency;
        null !== $client && $self['client'] = $client;
        null !== $clientAddress && $self['clientAddress'] = $clientAddress;
        null !== $clientCity && $self['clientCity'] = $clientCity;
        null !== $clientCountry && $self['clientCountry'] = $clientCountry;
        null !== $clientEmail && $self['clientEmail'] = $clientEmail;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $clientPhone && $self['clientPhone'] = $clientPhone;
        null !== $clientZipCode && $self['clientZipCode'] = $clientZipCode;
        null !== $company && $self['company'] = $company;
        null !== $companyName && $self['companyName'] = $companyName;
        null !== $date && $self['date'] = $date;
        null !== $invoiceLines && $self['invoiceLines'] = $invoiceLines;
        null !== $number && $self['number'] = $number;
        null !== $paymentExpiryDate && $self['paymentExpiryDate'] = $paymentExpiryDate;
        null !== $payments && $self['payments'] = $payments;
        null !== $state && $self['state'] = $state;
        null !== $title && $self['title'] = $title;
        null !== $totalHt && $self['totalHt'] = $totalHt;
        null !== $totalTtc && $self['totalTtc'] = $totalTtc;
        null !== $totalTva && $self['totalTva'] = $totalTva;
        null !== $type && $self['type'] = $type;
        null !== $vatRates && $self['vatRates'] = $vatRates;
        null !== $htmlLink && $self['htmlLink'] = $htmlLink;
        null !== $pdfLink && $self['pdfLink'] = $pdfLink;

        return $self;
    }

    /**
     * Unique identifier for the invoice.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * List of advance payments.
     *
     * @param list<AcompteShape> $acomptes
     */
    public function withAcomptes(array $acomptes): self
    {
        $self = clone $this;
        $self['acomptes'] = $acomptes;

        return $self;
    }

    /**
     * The currency with which the company works for this invoice.
     */
    public function withBaseCurrency(string $baseCurrency): self
    {
        $self = clone $this;
        $self['baseCurrency'] = $baseCurrency;

        return $self;
    }

    /**
     * Reference to the client.
     */
    public function withClient(string $client): self
    {
        $self = clone $this;
        $self['client'] = $client;

        return $self;
    }

    /**
     * Address of the client.
     */
    public function withClientAddress(string $clientAddress): self
    {
        $self = clone $this;
        $self['clientAddress'] = $clientAddress;

        return $self;
    }

    /**
     * City of the client.
     */
    public function withClientCity(string $clientCity): self
    {
        $self = clone $this;
        $self['clientCity'] = $clientCity;

        return $self;
    }

    /**
     * Country of the client.
     */
    public function withClientCountry(string $clientCountry): self
    {
        $self = clone $this;
        $self['clientCountry'] = $clientCountry;

        return $self;
    }

    /**
     * Email of the client.
     */
    public function withClientEmail(string $clientEmail): self
    {
        $self = clone $this;
        $self['clientEmail'] = $clientEmail;

        return $self;
    }

    /**
     * Name of the client.
     */
    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    /**
     * Phone number of the client.
     */
    public function withClientPhone(string $clientPhone): self
    {
        $self = clone $this;
        $self['clientPhone'] = $clientPhone;

        return $self;
    }

    /**
     * Zip code of the client.
     */
    public function withClientZipCode(string $clientZipCode): self
    {
        $self = clone $this;
        $self['clientZipCode'] = $clientZipCode;

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

    /**
     * Name of the company.
     */
    public function withCompanyName(string $companyName): self
    {
        $self = clone $this;
        $self['companyName'] = $companyName;

        return $self;
    }

    /**
     * Date of the invoice.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * List of invoice lines.
     *
     * @param list<InvoiceLineShape> $invoiceLines
     */
    public function withInvoiceLines(array $invoiceLines): self
    {
        $self = clone $this;
        $self['invoiceLines'] = $invoiceLines;

        return $self;
    }

    /**
     * Invoice number.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * Expiry date for payment.
     */
    public function withPaymentExpiryDate(
        \DateTimeInterface $paymentExpiryDate
    ): self {
        $self = clone $this;
        $self['paymentExpiryDate'] = $paymentExpiryDate;

        return $self;
    }

    /**
     * List of payments.
     *
     * @param list<PaymentShape> $payments
     */
    public function withPayments(array $payments): self
    {
        $self = clone $this;
        $self['payments'] = $payments;

        return $self;
    }

    /**
     * State of the invoice.
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * Short description or label of the invoice.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Total amount without tax.
     */
    public function withTotalHt(float $totalHt): self
    {
        $self = clone $this;
        $self['totalHt'] = $totalHt;

        return $self;
    }

    /**
     * Total amount with tax.
     */
    public function withTotalTtc(float $totalTtc): self
    {
        $self = clone $this;
        $self['totalTtc'] = $totalTtc;

        return $self;
    }

    /**
     * Total tax amount.
     */
    public function withTotalTva(float $totalTva): self
    {
        $self = clone $this;
        $self['totalTva'] = $totalTva;

        return $self;
    }

    /**
     * Type of the invoice.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * List of VAT rates applied to the invoice.
     *
     * @param list<VatRateShape> $vatRates
     */
    public function withVatRates(array $vatRates): self
    {
        $self = clone $this;
        $self['vatRates'] = $vatRates;

        return $self;
    }

    /**
     * Lien vers la version HTML.
     */
    public function withHTMLLink(string $htmlLink): self
    {
        $self = clone $this;
        $self['htmlLink'] = $htmlLink;

        return $self;
    }

    /**
     * Lien vers le PDF.
     */
    public function withPdfLink(string $pdfLink): self
    {
        $self = clone $this;
        $self['pdfLink'] = $pdfLink;

        return $self;
    }
}
