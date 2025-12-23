<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\Line;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State;

/**
 * Met à jour un bon de livraison existant.
 *
 * ## Gestion de la numérotation
 *
 * Si le bon passe à un état "validé" (waiting, shipped, delivered) et n'a pas encore de numéro,
 * un numéro officiel est automatiquement attribué via le système de numérotation.
 *
 * ## États disponibles
 *
 * - **draft** : Brouillon (modifiable librement)
 * - **waiting** : En attente d'expédition
 * - **shipped** : Expédié
 * - **delivered** : Livré
 * - **refused** : Refusé par le client
 * - **canceled** : Annulé
 * - **inactive** : Supprimé (soft delete)
 *
 * ## Événement déclenché
 *
 * Un événement `UPDATE_RECEIPT` est émis après la mise à jour.
 *
 * @see Wuro\Services\DeliveryReceiptsService::update()
 *
 * @phpstan-import-type LineShape from \Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\Line
 *
 * @phpstan-type DeliveryReceiptUpdateParamsShape = array{
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
 * }
 */
final class DeliveryReceiptUpdateParams implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Adresse du client.
     */
    #[Optional('client_address')]
    public ?string $clientAddress;

    /**
     * Ville du client.
     */
    #[Optional('client_city')]
    public ?string $clientCity;

    /**
     * Pays du client.
     */
    #[Optional('client_country')]
    public ?string $clientCountry;

    /**
     * Email du client.
     */
    #[Optional('client_email')]
    public ?string $clientEmail;

    /**
     * Nom du client.
     */
    #[Optional('client_name')]
    public ?string $clientName;

    /**
     * Code postal du client.
     */
    #[Optional('client_zip_code')]
    public ?string $clientZipCode;

    /**
     * Date du bon de livraison.
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
     * Date d'expédition.
     */
    #[Optional('shipping_date')]
    public ?\DateTimeInterface $shippingDate;

    /**
     * État du bon de livraison :
     * - **draft** : Brouillon
     * - **waiting** : En attente d'expédition
     * - **shipped** : Expédié
     * - **delivered** : Livré
     * - **refused** : Refusé
     * - **canceled** : Annulé
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
     */
    public static function with(
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
    ): self {
        $self = new self;

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

        return $self;
    }

    /**
     * Adresse du client.
     */
    public function withClientAddress(string $clientAddress): self
    {
        $self = clone $this;
        $self['clientAddress'] = $clientAddress;

        return $self;
    }

    /**
     * Ville du client.
     */
    public function withClientCity(string $clientCity): self
    {
        $self = clone $this;
        $self['clientCity'] = $clientCity;

        return $self;
    }

    /**
     * Pays du client.
     */
    public function withClientCountry(string $clientCountry): self
    {
        $self = clone $this;
        $self['clientCountry'] = $clientCountry;

        return $self;
    }

    /**
     * Email du client.
     */
    public function withClientEmail(string $clientEmail): self
    {
        $self = clone $this;
        $self['clientEmail'] = $clientEmail;

        return $self;
    }

    /**
     * Nom du client.
     */
    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    /**
     * Code postal du client.
     */
    public function withClientZipCode(string $clientZipCode): self
    {
        $self = clone $this;
        $self['clientZipCode'] = $clientZipCode;

        return $self;
    }

    /**
     * Date du bon de livraison.
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
     * Date d'expédition.
     */
    public function withShippingDate(\DateTimeInterface $shippingDate): self
    {
        $self = clone $this;
        $self['shippingDate'] = $shippingDate;

        return $self;
    }

    /**
     * État du bon de livraison :
     * - **draft** : Brouillon
     * - **waiting** : En attente d'expédition
     * - **shipped** : Expédié
     * - **delivered** : Livré
     * - **refused** : Refusé
     * - **canceled** : Annulé
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
}
