<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Clients\Client\State;
use Wuro\Clients\Client\Stats;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type StatsShape from \Wuro\Clients\Client\Stats
 *
 * @phpstan-type ClientShape = array{
 *   _id?: string|null,
 *   address?: string|null,
 *   addressComplement?: string|null,
 *   addressEnd?: string|null,
 *   analyticalCode?: string|null,
 *   avatar?: mixed,
 *   category?: string|null,
 *   city?: string|null,
 *   clientCode?: string|null,
 *   clientContact?: string|null,
 *   company?: string|null,
 *   country?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   email?: string|null,
 *   extraData?: mixed,
 *   fax?: string|null,
 *   mainInterlocutor?: string|null,
 *   mobile?: string|null,
 *   mobileFormat?: string|null,
 *   name?: string|null,
 *   nic?: string|null,
 *   notes?: string|null,
 *   phone?: string|null,
 *   phoneFormat?: string|null,
 *   positionCreator?: string|null,
 *   positionLastUpdator?: string|null,
 *   positionsAssigned?: list<string>|null,
 *   siren?: string|null,
 *   state?: null|State|value-of<State>,
 *   stats?: null|Stats|StatsShape,
 *   tags?: list<string>|null,
 *   tvaNumber?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   website?: string|null,
 *   zipCode?: string|null,
 * }
 */
final class Client implements BaseModel
{
    /** @use SdkModel<ClientShape> */
    use SdkModel;

    /**
     * Unique identifier for the client.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Street address.
     */
    #[Optional]
    public ?string $address;

    /**
     * Address complement.
     */
    #[Optional('address_complement')]
    public ?string $addressComplement;

    /**
     * Additional address information.
     */
    #[Optional('address_end')]
    public ?string $addressEnd;

    /**
     * Analytical code.
     */
    #[Optional('analytical_code')]
    public ?string $analyticalCode;

    /**
     * Client avatar image.
     */
    #[Optional]
    public mixed $avatar;

    /**
     * Client category.
     */
    #[Optional]
    public ?string $category;

    /**
     * City.
     */
    #[Optional]
    public ?string $city;

    /**
     * Client code for accounting.
     */
    #[Optional('client_code')]
    public ?string $clientCode;

    /**
     * Reference to main contact interlocutor.
     */
    #[Optional('client_contact')]
    public ?string $clientContact;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Country.
     */
    #[Optional]
    public ?string $country;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Client description.
     */
    #[Optional]
    public ?string $description;

    /**
     * Email of the client.
     */
    #[Optional]
    public ?string $email;

    /**
     * Custom extra data.
     */
    #[Optional]
    public mixed $extraData;

    /**
     * Fax number.
     */
    #[Optional]
    public ?string $fax;

    /**
     * Reference to main interlocutor.
     */
    #[Optional]
    public ?string $mainInterlocutor;

    /**
     * Mobile phone number.
     */
    #[Optional]
    public ?string $mobile;

    /**
     * Formatted mobile number for search.
     */
    #[Optional]
    public ?string $mobileFormat;

    /**
     * Name of the client (required).
     */
    #[Optional]
    public ?string $name;

    /**
     * NIC code.
     */
    #[Optional]
    public ?string $nic;

    /**
     * Notes about the client.
     */
    #[Optional]
    public ?string $notes;

    /**
     * Phone number.
     */
    #[Optional]
    public ?string $phone;

    /**
     * Formatted phone number for search.
     */
    #[Optional]
    public ?string $phoneFormat;

    /**
     * Position that created this client.
     */
    #[Optional]
    public ?string $positionCreator;

    /**
     * Position that last updated this client.
     */
    #[Optional]
    public ?string $positionLastUpdator;

    /**
     * List of assigned positions.
     *
     * @var list<string>|null $positionsAssigned
     */
    #[Optional(list: 'string')]
    public ?array $positionsAssigned;

    /**
     * SIREN number.
     */
    #[Optional]
    public ?string $siren;

    /**
     * Client state.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    #[Optional]
    public ?Stats $stats;

    /**
     * List of tag references.
     *
     * @var list<string>|null $tags
     */
    #[Optional(list: 'string')]
    public ?array $tags;

    /**
     * VAT number.
     */
    #[Optional('tva_number')]
    public ?string $tvaNumber;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Website URL.
     */
    #[Optional]
    public ?string $website;

    /**
     * Zip code.
     */
    #[Optional('zip_code')]
    public ?string $zipCode;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $positionsAssigned
     * @param State|value-of<State>|null $state
     * @param Stats|StatsShape|null $stats
     * @param list<string>|null $tags
     */
    public static function with(
        ?string $_id = null,
        ?string $address = null,
        ?string $addressComplement = null,
        ?string $addressEnd = null,
        ?string $analyticalCode = null,
        mixed $avatar = null,
        ?string $category = null,
        ?string $city = null,
        ?string $clientCode = null,
        ?string $clientContact = null,
        ?string $company = null,
        ?string $country = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $email = null,
        mixed $extraData = null,
        ?string $fax = null,
        ?string $mainInterlocutor = null,
        ?string $mobile = null,
        ?string $mobileFormat = null,
        ?string $name = null,
        ?string $nic = null,
        ?string $notes = null,
        ?string $phone = null,
        ?string $phoneFormat = null,
        ?string $positionCreator = null,
        ?string $positionLastUpdator = null,
        ?array $positionsAssigned = null,
        ?string $siren = null,
        State|string|null $state = null,
        Stats|array|null $stats = null,
        ?array $tags = null,
        ?string $tvaNumber = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $website = null,
        ?string $zipCode = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $address && $self['address'] = $address;
        null !== $addressComplement && $self['addressComplement'] = $addressComplement;
        null !== $addressEnd && $self['addressEnd'] = $addressEnd;
        null !== $analyticalCode && $self['analyticalCode'] = $analyticalCode;
        null !== $avatar && $self['avatar'] = $avatar;
        null !== $category && $self['category'] = $category;
        null !== $city && $self['city'] = $city;
        null !== $clientCode && $self['clientCode'] = $clientCode;
        null !== $clientContact && $self['clientContact'] = $clientContact;
        null !== $company && $self['company'] = $company;
        null !== $country && $self['country'] = $country;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $email && $self['email'] = $email;
        null !== $extraData && $self['extraData'] = $extraData;
        null !== $fax && $self['fax'] = $fax;
        null !== $mainInterlocutor && $self['mainInterlocutor'] = $mainInterlocutor;
        null !== $mobile && $self['mobile'] = $mobile;
        null !== $mobileFormat && $self['mobileFormat'] = $mobileFormat;
        null !== $name && $self['name'] = $name;
        null !== $nic && $self['nic'] = $nic;
        null !== $notes && $self['notes'] = $notes;
        null !== $phone && $self['phone'] = $phone;
        null !== $phoneFormat && $self['phoneFormat'] = $phoneFormat;
        null !== $positionCreator && $self['positionCreator'] = $positionCreator;
        null !== $positionLastUpdator && $self['positionLastUpdator'] = $positionLastUpdator;
        null !== $positionsAssigned && $self['positionsAssigned'] = $positionsAssigned;
        null !== $siren && $self['siren'] = $siren;
        null !== $state && $self['state'] = $state;
        null !== $stats && $self['stats'] = $stats;
        null !== $tags && $self['tags'] = $tags;
        null !== $tvaNumber && $self['tvaNumber'] = $tvaNumber;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $website && $self['website'] = $website;
        null !== $zipCode && $self['zipCode'] = $zipCode;

        return $self;
    }

    /**
     * Unique identifier for the client.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Street address.
     */
    public function withAddress(string $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    /**
     * Address complement.
     */
    public function withAddressComplement(string $addressComplement): self
    {
        $self = clone $this;
        $self['addressComplement'] = $addressComplement;

        return $self;
    }

    /**
     * Additional address information.
     */
    public function withAddressEnd(string $addressEnd): self
    {
        $self = clone $this;
        $self['addressEnd'] = $addressEnd;

        return $self;
    }

    /**
     * Analytical code.
     */
    public function withAnalyticalCode(string $analyticalCode): self
    {
        $self = clone $this;
        $self['analyticalCode'] = $analyticalCode;

        return $self;
    }

    /**
     * Client avatar image.
     */
    public function withAvatar(mixed $avatar): self
    {
        $self = clone $this;
        $self['avatar'] = $avatar;

        return $self;
    }

    /**
     * Client category.
     */
    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * City.
     */
    public function withCity(string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    /**
     * Client code for accounting.
     */
    public function withClientCode(string $clientCode): self
    {
        $self = clone $this;
        $self['clientCode'] = $clientCode;

        return $self;
    }

    /**
     * Reference to main contact interlocutor.
     */
    public function withClientContact(string $clientContact): self
    {
        $self = clone $this;
        $self['clientContact'] = $clientContact;

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
     * Country.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Client description.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Email of the client.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Custom extra data.
     */
    public function withExtraData(mixed $extraData): self
    {
        $self = clone $this;
        $self['extraData'] = $extraData;

        return $self;
    }

    /**
     * Fax number.
     */
    public function withFax(string $fax): self
    {
        $self = clone $this;
        $self['fax'] = $fax;

        return $self;
    }

    /**
     * Reference to main interlocutor.
     */
    public function withMainInterlocutor(string $mainInterlocutor): self
    {
        $self = clone $this;
        $self['mainInterlocutor'] = $mainInterlocutor;

        return $self;
    }

    /**
     * Mobile phone number.
     */
    public function withMobile(string $mobile): self
    {
        $self = clone $this;
        $self['mobile'] = $mobile;

        return $self;
    }

    /**
     * Formatted mobile number for search.
     */
    public function withMobileFormat(string $mobileFormat): self
    {
        $self = clone $this;
        $self['mobileFormat'] = $mobileFormat;

        return $self;
    }

    /**
     * Name of the client (required).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * NIC code.
     */
    public function withNic(string $nic): self
    {
        $self = clone $this;
        $self['nic'] = $nic;

        return $self;
    }

    /**
     * Notes about the client.
     */
    public function withNotes(string $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

        return $self;
    }

    /**
     * Phone number.
     */
    public function withPhone(string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    /**
     * Formatted phone number for search.
     */
    public function withPhoneFormat(string $phoneFormat): self
    {
        $self = clone $this;
        $self['phoneFormat'] = $phoneFormat;

        return $self;
    }

    /**
     * Position that created this client.
     */
    public function withPositionCreator(string $positionCreator): self
    {
        $self = clone $this;
        $self['positionCreator'] = $positionCreator;

        return $self;
    }

    /**
     * Position that last updated this client.
     */
    public function withPositionLastUpdator(string $positionLastUpdator): self
    {
        $self = clone $this;
        $self['positionLastUpdator'] = $positionLastUpdator;

        return $self;
    }

    /**
     * List of assigned positions.
     *
     * @param list<string> $positionsAssigned
     */
    public function withPositionsAssigned(array $positionsAssigned): self
    {
        $self = clone $this;
        $self['positionsAssigned'] = $positionsAssigned;

        return $self;
    }

    /**
     * SIREN number.
     */
    public function withSiren(string $siren): self
    {
        $self = clone $this;
        $self['siren'] = $siren;

        return $self;
    }

    /**
     * Client state.
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
     * @param Stats|StatsShape $stats
     */
    public function withStats(Stats|array $stats): self
    {
        $self = clone $this;
        $self['stats'] = $stats;

        return $self;
    }

    /**
     * List of tag references.
     *
     * @param list<string> $tags
     */
    public function withTags(array $tags): self
    {
        $self = clone $this;
        $self['tags'] = $tags;

        return $self;
    }

    /**
     * VAT number.
     */
    public function withTvaNumber(string $tvaNumber): self
    {
        $self = clone $this;
        $self['tvaNumber'] = $tvaNumber;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Website URL.
     */
    public function withWebsite(string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }

    /**
     * Zip code.
     */
    public function withZipCode(string $zipCode): self
    {
        $self = clone $this;
        $self['zipCode'] = $zipCode;

        return $self;
    }
}
