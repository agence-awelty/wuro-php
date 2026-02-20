<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Quotes\Line\QuoteLine;
use Wuro\Quotes\QuoteUpdateParams\State;
use Wuro\Quotes\QuoteUpdateParams\Type;

/**
 * Met à jour un devis existant.
 *
 * **Numérotation automatique:**
 * - Si le devis passe de 'draft' à un état validé (pending, waiting, accepted, etc.), un numéro est automatiquement attribué
 * - La date est mise à jour automatiquement lors de la numérotation
 *
 * **Événement déclenché:** UPDATE_QUOTE
 *
 * @see Wuro\Services\QuotesService::update()
 *
 * @phpstan-import-type QuoteLineShape from \Wuro\Quotes\Line\QuoteLine
 *
 * @phpstan-type QuoteUpdateParamsShape = array{
 *   client?: string|null,
 *   clientAddress?: string|null,
 *   clientCity?: string|null,
 *   clientCountry?: string|null,
 *   clientEmail?: string|null,
 *   clientName?: string|null,
 *   clientZipCode?: string|null,
 *   date?: \DateTimeInterface|null,
 *   expiryDate?: \DateTimeInterface|null,
 *   quoteLines?: list<QuoteLine|QuoteLineShape>|null,
 *   state?: null|State|value-of<State>,
 *   title?: string|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class QuoteUpdateParams implements BaseModel
{
    /** @use SdkModel<QuoteUpdateParamsShape> */
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

    #[Optional('client_email')]
    public ?string $clientEmail;

    #[Optional('client_name')]
    public ?string $clientName;

    #[Optional('client_zip_code')]
    public ?string $clientZipCode;

    /**
     * Date du devis.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Date de validité.
     */
    #[Optional('expiry_date')]
    public ?\DateTimeInterface $expiryDate;

    /** @var list<QuoteLine>|null $quoteLines */
    #[Optional('quote_lines', list: QuoteLine::class)]
    public ?array $quoteLines;

    /**
     * État du devis.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Titre/objet du devis.
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
     * @param list<QuoteLine|QuoteLineShape>|null $quoteLines
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
        ?\DateTimeInterface $expiryDate = null,
        ?array $quoteLines = null,
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
        null !== $expiryDate && $self['expiryDate'] = $expiryDate;
        null !== $quoteLines && $self['quoteLines'] = $quoteLines;
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

    public function withClientEmail(string $clientEmail): self
    {
        $self = clone $this;
        $self['clientEmail'] = $clientEmail;

        return $self;
    }

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
     * Date du devis.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Date de validité.
     */
    public function withExpiryDate(\DateTimeInterface $expiryDate): self
    {
        $self = clone $this;
        $self['expiryDate'] = $expiryDate;

        return $self;
    }

    /**
     * @param list<QuoteLine|QuoteLineShape> $quoteLines
     */
    public function withQuoteLines(array $quoteLines): self
    {
        $self = clone $this;
        $self['quoteLines'] = $quoteLines;

        return $self;
    }

    /**
     * État du devis.
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
     * Titre/objet du devis.
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
