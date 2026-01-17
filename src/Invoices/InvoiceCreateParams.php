<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceCreateParams\InvoiceLine;
use Wuro\Invoices\InvoiceCreateParams\State;
use Wuro\Invoices\InvoiceCreateParams\Type;

/**
 * Crée une nouvelle facture.
 *
 * **Numérotation automatique:**
 * - Si l'état est 'waiting', 'paid', 'notpaid' ou 'late', un numéro est automatiquement attribué
 * - Le système verrouille la numérotation pendant l'attribution pour éviter les doublons
 * - Un numéro d'enregistrement FEC (numberRecord) est aussi généré
 *
 * **Types de factures:**
 * - `invoice`: Facture standard
 * - `invoice_credit`: Avoir
 * - `external`: Facture externe (client fournisseur)
 * - `external_credit`: Avoir externe
 * - `proforma`: Facture proforma
 * - `advance`: Acompte
 *
 * **Calculs automatiques:**
 * - Les totaux HT, TVA et TTC sont calculés automatiquement
 * - Les réductions globales sont appliquées
 * - La date d'échéance est calculée selon les paramètres de l'entreprise
 *
 * **Événements déclenchés:**
 * - CREATE_INVOICE
 * - Mise à jour du stock si nécessaire
 *
 * **Réponse:**
 * - Inclut les liens `pdf_link` et `html_link` pour accéder aux documents
 *
 * @see Wuro\Services\InvoicesService::create()
 *
 * @phpstan-import-type InvoiceLineShape from \Wuro\Invoices\InvoiceCreateParams\InvoiceLine
 *
 * @phpstan-type InvoiceCreateParamsShape = array{
 *   client?: string|null,
 *   clientAddress?: string|null,
 *   clientCity?: string|null,
 *   clientCountry?: string|null,
 *   clientEmail?: string|null,
 *   clientName?: string|null,
 *   clientZipCode?: string|null,
 *   date?: \DateTimeInterface|null,
 *   invoiceLines?: list<InvoiceLine|InvoiceLineShape>|null,
 *   paymentExpiryDate?: \DateTimeInterface|null,
 *   state?: null|State|value-of<State>,
 *   title?: string|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class InvoiceCreateParams implements BaseModel
{
    /** @use SdkModel<InvoiceCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID du client.
     */
    #[Optional]
    public ?string $client;

    #[Optional('client_address')]
    public ?string $clientAddress;

    #[Optional('client_city')]
    public ?string $clientCity;

    #[Optional('client_country')]
    public ?string $clientCountry;

    /**
     * Email pour l'envoi de la facture.
     */
    #[Optional('client_email')]
    public ?string $clientEmail;

    /**
     * Nom du client (si pas de client référencé).
     */
    #[Optional('client_name')]
    public ?string $clientName;

    #[Optional('client_zip_code')]
    public ?string $clientZipCode;

    /**
     * Date de la facture (défaut = maintenant).
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Lignes de la facture.
     *
     * @var list<InvoiceLine>|null $invoiceLines
     */
    #[Optional('invoice_lines', list: InvoiceLine::class)]
    public ?array $invoiceLines;

    /**
     * Date d'échéance (calculée automatiquement si non fournie).
     */
    #[Optional('payment_expiry_date')]
    public ?\DateTimeInterface $paymentExpiryDate;

    /**
     * État initial (draft = brouillon sans numéro).
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Titre/objet de la facture.
     */
    #[Optional]
    public ?string $title;

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
     * @param list<InvoiceLine|InvoiceLineShape>|null $invoiceLines
     * @param State|value-of<State>|null $state
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $client = null,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        ?string $clientCountry = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?array $invoiceLines = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        State|string|null $state = null,
        ?string $title = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $client && $self['client'] = $client;
        null !== $clientAddress && $self['clientAddress'] = $clientAddress;
        null !== $clientCity && $self['clientCity'] = $clientCity;
        null !== $clientCountry && $self['clientCountry'] = $clientCountry;
        null !== $clientEmail && $self['clientEmail'] = $clientEmail;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $clientZipCode && $self['clientZipCode'] = $clientZipCode;
        null !== $date && $self['date'] = $date;
        null !== $invoiceLines && $self['invoiceLines'] = $invoiceLines;
        null !== $paymentExpiryDate && $self['paymentExpiryDate'] = $paymentExpiryDate;
        null !== $state && $self['state'] = $state;
        null !== $title && $self['title'] = $title;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * ID du client.
     */
    public function withClient(string $client): self
    {
        $self = clone $this;
        $self['client'] = $client;

        return $self;
    }

    public function withClientAddress(string $clientAddress): self
    {
        $self = clone $this;
        $self['clientAddress'] = $clientAddress;

        return $self;
    }

    public function withClientCity(string $clientCity): self
    {
        $self = clone $this;
        $self['clientCity'] = $clientCity;

        return $self;
    }

    public function withClientCountry(string $clientCountry): self
    {
        $self = clone $this;
        $self['clientCountry'] = $clientCountry;

        return $self;
    }

    /**
     * Email pour l'envoi de la facture.
     */
    public function withClientEmail(string $clientEmail): self
    {
        $self = clone $this;
        $self['clientEmail'] = $clientEmail;

        return $self;
    }

    /**
     * Nom du client (si pas de client référencé).
     */
    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    public function withClientZipCode(string $clientZipCode): self
    {
        $self = clone $this;
        $self['clientZipCode'] = $clientZipCode;

        return $self;
    }

    /**
     * Date de la facture (défaut = maintenant).
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Lignes de la facture.
     *
     * @param list<InvoiceLine|InvoiceLineShape> $invoiceLines
     */
    public function withInvoiceLines(array $invoiceLines): self
    {
        $self = clone $this;
        $self['invoiceLines'] = $invoiceLines;

        return $self;
    }

    /**
     * Date d'échéance (calculée automatiquement si non fournie).
     */
    public function withPaymentExpiryDate(
        \DateTimeInterface $paymentExpiryDate
    ): self {
        $self = clone $this;
        $self['paymentExpiryDate'] = $paymentExpiryDate;

        return $self;
    }

    /**
     * État initial (draft = brouillon sans numéro).
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
     * Titre/objet de la facture.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

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
