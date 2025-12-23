<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\State;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Type;

/**
 * Crée un nouveau bon de livraison.
 *
 * ## Numérotation automatique
 *
 * Le numéro est attribué automatiquement lorsque le bon passe en état validé
 * (waiting, shipped, delivered). Un bon en brouillon (draft) n'a pas de numéro.
 *
 * ## Structure des lignes
 *
 * Les lignes peuvent être de deux types :
 * - **product** : Ligne produit avec quantité, référence, poids
 * - **header** : Ligne de séparation/titre pour organiser le bon
 *
 * ## Lien avec devis/facture
 *
 * Vous pouvez créer un bon de livraison depuis un devis via `/quote/{uid}/delivery-receipt`
 * ou depuis une facture via `/invoice/{uid}/delivery-receipt`.
 *
 * ## Événement déclenché
 *
 * Un événement `CREATE_RECEIPT` est émis après la création.
 *
 * @see Wuro\Services\DeliveryReceiptsService::create()
 *
 * @phpstan-import-type LineShape from \Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line
 *
 * @phpstan-type DeliveryReceiptCreateParamsShape = array{
 *   client: string,
 *   clientAddress?: string|null,
 *   clientCity?: string|null,
 *   clientCountry?: string|null,
 *   clientEmail?: string|null,
 *   clientName?: string|null,
 *   clientZipCode?: string|null,
 *   date?: \DateTimeInterface|null,
 *   lines?: list<LineShape>|null,
 *   shippingDate?: \DateTimeInterface|null,
 *   state?: null|State|value-of<State>,
 *   title?: string|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class DeliveryReceiptCreateParams implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Référence du client (obligatoire).
     */
    #[Required]
    public string $client;

    /**
     * Adresse de livraison.
     */
    #[Optional('client_address')]
    public ?string $clientAddress;

    /**
     * Ville de livraison.
     */
    #[Optional('client_city')]
    public ?string $clientCity;

    /**
     * Pays de livraison.
     */
    #[Optional('client_country')]
    public ?string $clientCountry;

    /**
     * Email du client (pour envoi du bon).
     */
    #[Optional('client_email')]
    public ?string $clientEmail;

    /**
     * Nom du client (copié du client si non fourni).
     */
    #[Optional('client_name')]
    public ?string $clientName;

    /**
     * Code postal.
     */
    #[Optional('client_zip_code')]
    public ?string $clientZipCode;

    /**
     * Date du bon (par défaut aujourd'hui).
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Lignes du bon de livraison.
     *
     * @var list<Line>|null $lines
     */
    #[Optional(list: Line::class)]
    public ?array $lines;

    /**
     * Date d'expédition prévue.
     */
    #[Optional('shipping_date')]
    public ?\DateTimeInterface $shippingDate;

    /**
     * État initial du bon.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Description courte ou libellé du bon.
     */
    #[Optional]
    public ?string $title;

    /**
     * Type de document (delivery par défaut).
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * `new DeliveryReceiptCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeliveryReceiptCreateParams::with(client: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeliveryReceiptCreateParams)->withClient(...)
     * ```
     */
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
        string $client,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        ?string $clientCountry = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?array $lines = null,
        ?\DateTimeInterface $shippingDate = null,
        State|string|null $state = null,
        ?string $title = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        $self['client'] = $client;

        null !== $clientAddress && $self['clientAddress'] = $clientAddress;
        null !== $clientCity && $self['clientCity'] = $clientCity;
        null !== $clientCountry && $self['clientCountry'] = $clientCountry;
        null !== $clientEmail && $self['clientEmail'] = $clientEmail;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $clientZipCode && $self['clientZipCode'] = $clientZipCode;
        null !== $date && $self['date'] = $date;
        null !== $lines && $self['lines'] = $lines;
        null !== $shippingDate && $self['shippingDate'] = $shippingDate;
        null !== $state && $self['state'] = $state;
        null !== $title && $self['title'] = $title;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Référence du client (obligatoire).
     */
    public function withClient(string $client): self
    {
        $self = clone $this;
        $self['client'] = $client;

        return $self;
    }

    /**
     * Adresse de livraison.
     */
    public function withClientAddress(string $clientAddress): self
    {
        $self = clone $this;
        $self['clientAddress'] = $clientAddress;

        return $self;
    }

    /**
     * Ville de livraison.
     */
    public function withClientCity(string $clientCity): self
    {
        $self = clone $this;
        $self['clientCity'] = $clientCity;

        return $self;
    }

    /**
     * Pays de livraison.
     */
    public function withClientCountry(string $clientCountry): self
    {
        $self = clone $this;
        $self['clientCountry'] = $clientCountry;

        return $self;
    }

    /**
     * Email du client (pour envoi du bon).
     */
    public function withClientEmail(string $clientEmail): self
    {
        $self = clone $this;
        $self['clientEmail'] = $clientEmail;

        return $self;
    }

    /**
     * Nom du client (copié du client si non fourni).
     */
    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    /**
     * Code postal.
     */
    public function withClientZipCode(string $clientZipCode): self
    {
        $self = clone $this;
        $self['clientZipCode'] = $clientZipCode;

        return $self;
    }

    /**
     * Date du bon (par défaut aujourd'hui).
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Lignes du bon de livraison.
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
     * Date d'expédition prévue.
     */
    public function withShippingDate(\DateTimeInterface $shippingDate): self
    {
        $self = clone $this;
        $self['shippingDate'] = $shippingDate;

        return $self;
    }

    /**
     * État initial du bon.
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
     * Description courte ou libellé du bon.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Type de document (delivery par défaut).
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
