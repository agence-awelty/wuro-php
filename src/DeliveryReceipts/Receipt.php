<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\DeliveryReceipts\Receipt\Line;
use Wuro\DeliveryReceipts\Receipt\State;
use Wuro\DeliveryReceipts\Receipt\Type;

/**
 * @phpstan-import-type LineShape from \Wuro\DeliveryReceipts\Receipt\Line
 *
 * @phpstan-type ReceiptShape = array{
 *   _id?: string|null,
 *   client?: string|null,
 *   clientContact?: string|null,
 *   clientEmail?: string|null,
 *   clientMobile?: string|null,
 *   clientName?: string|null,
 *   comment?: string|null,
 *   company?: string|null,
 *   companyName?: string|null,
 *   date?: \DateTimeInterface|null,
 *   deliveryAddress?: string|null,
 *   deliveryCity?: string|null,
 *   deliveryCountry?: string|null,
 *   deliveryDate?: string|null,
 *   deliveryZipCode?: string|null,
 *   fromInvoice?: string|null,
 *   fromQuote?: string|null,
 *   lines?: list<LineShape>|null,
 *   notes?: string|null,
 *   number?: string|null,
 *   numberOrder?: string|null,
 *   shippingDate?: \DateTimeInterface|null,
 *   shippingMethod?: string|null,
 *   shippingNbPackages?: float|null,
 *   state?: null|State|value-of<State>,
 *   title?: string|null,
 *   totalQuantity?: float|null,
 *   totalWeight?: float|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class Receipt implements BaseModel
{
    /** @use SdkModel<ReceiptShape> */
    use SdkModel;

    /**
     * Unique identifier for the delivery receipt.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Reference to the client.
     */
    #[Optional]
    public ?string $client;

    /**
     * Contact person at the client.
     */
    #[Optional('client_contact')]
    public ?string $clientContact;

    /**
     * Email of the client.
     */
    #[Optional('client_email')]
    public ?string $clientEmail;

    /**
     * Mobile phone of the client.
     */
    #[Optional('client_mobile')]
    public ?string $clientMobile;

    /**
     * Name of the client.
     */
    #[Optional('client_name')]
    public ?string $clientName;

    /**
     * Additional comments.
     */
    #[Optional]
    public ?string $comment;

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
     * Date of the delivery receipt.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Delivery address.
     */
    #[Optional('delivery_address')]
    public ?string $deliveryAddress;

    /**
     * Delivery city.
     */
    #[Optional('delivery_city')]
    public ?string $deliveryCity;

    /**
     * Delivery country.
     */
    #[Optional('delivery_country')]
    public ?string $deliveryCountry;

    /**
     * Delivery date.
     */
    #[Optional('delivery_date')]
    public ?string $deliveryDate;

    /**
     * Delivery zip code.
     */
    #[Optional('delivery_zip_code')]
    public ?string $deliveryZipCode;

    /**
     * Reference to the invoice if created from an invoice.
     */
    #[Optional]
    public ?string $fromInvoice;

    /**
     * Reference to the quote if created from a quote.
     */
    #[Optional]
    public ?string $fromQuote;

    /**
     * List of delivery receipt lines.
     *
     * @var list<Line>|null $lines
     */
    #[Optional(list: Line::class)]
    public ?array $lines;

    /**
     * Additional notes.
     */
    #[Optional]
    public ?string $notes;

    /**
     * Receipt number.
     */
    #[Optional]
    public ?string $number;

    /**
     * Order number.
     */
    #[Optional]
    public ?string $numberOrder;

    /**
     * Shipping date.
     */
    #[Optional('shipping_date')]
    public ?\DateTimeInterface $shippingDate;

    /**
     * Shipping method.
     */
    #[Optional('shipping_method')]
    public ?string $shippingMethod;

    /**
     * Number of packages.
     */
    #[Optional]
    public ?float $shippingNbPackages;

    /**
     * State of the delivery receipt.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Short description or label of the delivery receipt.
     */
    #[Optional]
    public ?string $title;

    /**
     * Total quantity of all products.
     */
    #[Optional]
    public ?float $totalQuantity;

    /**
     * Total weight of all products.
     */
    #[Optional]
    public ?float $totalWeight;

    /**
     * Type of the receipt.
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
     * @param list<LineShape>|null $lines
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $_id = null,
        ?string $client = null,
        ?string $clientContact = null,
        ?string $clientEmail = null,
        ?string $clientMobile = null,
        ?string $clientName = null,
        ?string $comment = null,
        ?string $company = null,
        ?string $companyName = null,
        ?\DateTimeInterface $date = null,
        ?string $deliveryAddress = null,
        ?string $deliveryCity = null,
        ?string $deliveryCountry = null,
        ?string $deliveryDate = null,
        ?string $deliveryZipCode = null,
        ?string $fromInvoice = null,
        ?string $fromQuote = null,
        ?array $lines = null,
        ?string $notes = null,
        ?string $number = null,
        ?string $numberOrder = null,
        ?\DateTimeInterface $shippingDate = null,
        ?string $shippingMethod = null,
        ?float $shippingNbPackages = null,
        State|string|null $state = null,
        ?string $title = null,
        ?float $totalQuantity = null,
        ?float $totalWeight = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $client && $self['client'] = $client;
        null !== $clientContact && $self['clientContact'] = $clientContact;
        null !== $clientEmail && $self['clientEmail'] = $clientEmail;
        null !== $clientMobile && $self['clientMobile'] = $clientMobile;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $comment && $self['comment'] = $comment;
        null !== $company && $self['company'] = $company;
        null !== $companyName && $self['companyName'] = $companyName;
        null !== $date && $self['date'] = $date;
        null !== $deliveryAddress && $self['deliveryAddress'] = $deliveryAddress;
        null !== $deliveryCity && $self['deliveryCity'] = $deliveryCity;
        null !== $deliveryCountry && $self['deliveryCountry'] = $deliveryCountry;
        null !== $deliveryDate && $self['deliveryDate'] = $deliveryDate;
        null !== $deliveryZipCode && $self['deliveryZipCode'] = $deliveryZipCode;
        null !== $fromInvoice && $self['fromInvoice'] = $fromInvoice;
        null !== $fromQuote && $self['fromQuote'] = $fromQuote;
        null !== $lines && $self['lines'] = $lines;
        null !== $notes && $self['notes'] = $notes;
        null !== $number && $self['number'] = $number;
        null !== $numberOrder && $self['numberOrder'] = $numberOrder;
        null !== $shippingDate && $self['shippingDate'] = $shippingDate;
        null !== $shippingMethod && $self['shippingMethod'] = $shippingMethod;
        null !== $shippingNbPackages && $self['shippingNbPackages'] = $shippingNbPackages;
        null !== $state && $self['state'] = $state;
        null !== $title && $self['title'] = $title;
        null !== $totalQuantity && $self['totalQuantity'] = $totalQuantity;
        null !== $totalWeight && $self['totalWeight'] = $totalWeight;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Unique identifier for the delivery receipt.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

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
     * Contact person at the client.
     */
    public function withClientContact(string $clientContact): self
    {
        $self = clone $this;
        $self['clientContact'] = $clientContact;

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
     * Mobile phone of the client.
     */
    public function withClientMobile(string $clientMobile): self
    {
        $self = clone $this;
        $self['clientMobile'] = $clientMobile;

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
     * Additional comments.
     */
    public function withComment(string $comment): self
    {
        $self = clone $this;
        $self['comment'] = $comment;

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
     * Date of the delivery receipt.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Delivery address.
     */
    public function withDeliveryAddress(string $deliveryAddress): self
    {
        $self = clone $this;
        $self['deliveryAddress'] = $deliveryAddress;

        return $self;
    }

    /**
     * Delivery city.
     */
    public function withDeliveryCity(string $deliveryCity): self
    {
        $self = clone $this;
        $self['deliveryCity'] = $deliveryCity;

        return $self;
    }

    /**
     * Delivery country.
     */
    public function withDeliveryCountry(string $deliveryCountry): self
    {
        $self = clone $this;
        $self['deliveryCountry'] = $deliveryCountry;

        return $self;
    }

    /**
     * Delivery date.
     */
    public function withDeliveryDate(string $deliveryDate): self
    {
        $self = clone $this;
        $self['deliveryDate'] = $deliveryDate;

        return $self;
    }

    /**
     * Delivery zip code.
     */
    public function withDeliveryZipCode(string $deliveryZipCode): self
    {
        $self = clone $this;
        $self['deliveryZipCode'] = $deliveryZipCode;

        return $self;
    }

    /**
     * Reference to the invoice if created from an invoice.
     */
    public function withFromInvoice(string $fromInvoice): self
    {
        $self = clone $this;
        $self['fromInvoice'] = $fromInvoice;

        return $self;
    }

    /**
     * Reference to the quote if created from a quote.
     */
    public function withFromQuote(string $fromQuote): self
    {
        $self = clone $this;
        $self['fromQuote'] = $fromQuote;

        return $self;
    }

    /**
     * List of delivery receipt lines.
     *
     * @param list<LineShape> $lines
     */
    public function withLines(array $lines): self
    {
        $self = clone $this;
        $self['lines'] = $lines;

        return $self;
    }

    /**
     * Additional notes.
     */
    public function withNotes(string $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

        return $self;
    }

    /**
     * Receipt number.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * Order number.
     */
    public function withNumberOrder(string $numberOrder): self
    {
        $self = clone $this;
        $self['numberOrder'] = $numberOrder;

        return $self;
    }

    /**
     * Shipping date.
     */
    public function withShippingDate(\DateTimeInterface $shippingDate): self
    {
        $self = clone $this;
        $self['shippingDate'] = $shippingDate;

        return $self;
    }

    /**
     * Shipping method.
     */
    public function withShippingMethod(string $shippingMethod): self
    {
        $self = clone $this;
        $self['shippingMethod'] = $shippingMethod;

        return $self;
    }

    /**
     * Number of packages.
     */
    public function withShippingNbPackages(float $shippingNbPackages): self
    {
        $self = clone $this;
        $self['shippingNbPackages'] = $shippingNbPackages;

        return $self;
    }

    /**
     * State of the delivery receipt.
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
     * Short description or label of the delivery receipt.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Total quantity of all products.
     */
    public function withTotalQuantity(float $totalQuantity): self
    {
        $self = clone $this;
        $self['totalQuantity'] = $totalQuantity;

        return $self;
    }

    /**
     * Total weight of all products.
     */
    public function withTotalWeight(float $totalWeight): self
    {
        $self = clone $this;
        $self['totalWeight'] = $totalWeight;

        return $self;
    }

    /**
     * Type of the receipt.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
