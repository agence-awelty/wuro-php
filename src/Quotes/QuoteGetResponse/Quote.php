<?php

declare(strict_types=1);

namespace Wuro\Quotes\QuoteGetResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\Line\VatRate;
use Wuro\Quotes\Line\Quote\Acompte;
use Wuro\Quotes\Line\Quote\State;
use Wuro\Quotes\Line\Quote\Type;
use Wuro\Quotes\Line\QuoteLine;

/**
 * @phpstan-import-type AcompteShape from \Wuro\Quotes\Line\Quote\Acompte
 * @phpstan-import-type QuoteLineShape from \Wuro\Quotes\Line\QuoteLine
 * @phpstan-import-type VatRateShape from \Wuro\Invoices\Line\VatRate
 *
 * @phpstan-type QuoteShape = array{
 *   _id?: string|null,
 *   acceptDate?: \DateTimeInterface|null,
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
 *   expiryDate?: \DateTimeInterface|null,
 *   number?: string|null,
 *   quoteLines?: list<QuoteLineShape>|null,
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
final class Quote implements BaseModel
{
    /** @use SdkModel<QuoteShape> */
    use SdkModel;

    /**
     * Unique identifier for the quote.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Date when the quote was accepted.
     */
    #[Optional('accept_date')]
    public ?\DateTimeInterface $acceptDate;

    /**
     * List of advance payments.
     *
     * @var list<Acompte>|null $acomptes
     */
    #[Optional(list: Acompte::class)]
    public ?array $acomptes;

    /**
     * The currency with which the company works for this quote.
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
     * Date of the quote.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Expiry date of the quote.
     */
    #[Optional('expiry_date')]
    public ?\DateTimeInterface $expiryDate;

    /**
     * Quote number.
     */
    #[Optional]
    public ?string $number;

    /**
     * List of quote lines.
     *
     * @var list<QuoteLine>|null $quoteLines
     */
    #[Optional('quote_lines', list: QuoteLine::class)]
    public ?array $quoteLines;

    /**
     * State of the quote.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Short description or label of the quote.
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
     * Type of the quote.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * List of VAT rates applied to the quote.
     *
     * @var list<VatRate>|null $vatRates
     */
    #[Optional('VATRates', list: VatRate::class)]
    public ?array $vatRates;

    #[Optional('html_link')]
    public ?string $htmlLink;

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
     * @param list<QuoteLineShape>|null $quoteLines
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     * @param list<VatRateShape>|null $vatRates
     */
    public static function with(
        ?string $_id = null,
        ?\DateTimeInterface $acceptDate = null,
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
        ?\DateTimeInterface $expiryDate = null,
        ?string $number = null,
        ?array $quoteLines = null,
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
        null !== $acceptDate && $self['acceptDate'] = $acceptDate;
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
        null !== $expiryDate && $self['expiryDate'] = $expiryDate;
        null !== $number && $self['number'] = $number;
        null !== $quoteLines && $self['quoteLines'] = $quoteLines;
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
     * Unique identifier for the quote.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Date when the quote was accepted.
     */
    public function withAcceptDate(\DateTimeInterface $acceptDate): self
    {
        $self = clone $this;
        $self['acceptDate'] = $acceptDate;

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
     * The currency with which the company works for this quote.
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
     * Date of the quote.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Expiry date of the quote.
     */
    public function withExpiryDate(\DateTimeInterface $expiryDate): self
    {
        $self = clone $this;
        $self['expiryDate'] = $expiryDate;

        return $self;
    }

    /**
     * Quote number.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * List of quote lines.
     *
     * @param list<QuoteLineShape> $quoteLines
     */
    public function withQuoteLines(array $quoteLines): self
    {
        $self = clone $this;
        $self['quoteLines'] = $quoteLines;

        return $self;
    }

    /**
     * State of the quote.
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
     * Short description or label of the quote.
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
     * Type of the quote.
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
     * List of VAT rates applied to the quote.
     *
     * @param list<VatRateShape> $vatRates
     */
    public function withVatRates(array $vatRates): self
    {
        $self = clone $this;
        $self['vatRates'] = $vatRates;

        return $self;
    }

    public function withHTMLLink(string $htmlLink): self
    {
        $self = clone $this;
        $self['htmlLink'] = $htmlLink;

        return $self;
    }

    public function withPdfLink(string $pdfLink): self
    {
        $self = clone $this;
        $self['pdfLink'] = $pdfLink;

        return $self;
    }
}
