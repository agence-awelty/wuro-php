<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Met à jour les informations d'un client existant.
 *
 * Vous pouvez modifier :
 * - Les coordonnées (nom, adresse, contacts)
 * - Les informations fiscales (SIRET, TVA)
 * - Les conditions commerciales
 * - L'état (active/inactive pour archiver)
 *
 * ## Événement déclenché
 *
 * Un événement `UPDATE_CLIENT` est émis après la mise à jour.
 *
 * @see Wuro\Services\ClientsService::update()
 *
 * @phpstan-type ClientUpdateParamsShape = array{
 *   name: string,
 *   address?: string|null,
 *   addressComplement?: string|null,
 *   addressEnd?: string|null,
 *   analyticalCode?: string|null,
 *   category?: string|null,
 *   city?: string|null,
 *   clientCode?: string|null,
 *   country?: string|null,
 *   description?: string|null,
 *   email?: string|null,
 *   fax?: string|null,
 *   mobile?: string|null,
 *   nic?: string|null,
 *   notes?: string|null,
 *   phone?: string|null,
 *   siren?: string|null,
 *   tags?: list<string>|null,
 *   tvaNumber?: string|null,
 *   website?: string|null,
 *   zipCode?: string|null,
 * }
 */
final class ClientUpdateParams implements BaseModel
{
    /** @use SdkModel<ClientUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Name of the client (required).
     */
    #[Required]
    public string $name;

    #[Optional]
    public ?string $address;

    #[Optional('address_complement')]
    public ?string $addressComplement;

    #[Optional('address_end')]
    public ?string $addressEnd;

    #[Optional('analytical_code')]
    public ?string $analyticalCode;

    #[Optional]
    public ?string $category;

    #[Optional]
    public ?string $city;

    #[Optional('client_code')]
    public ?string $clientCode;

    #[Optional]
    public ?string $country;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $email;

    #[Optional]
    public ?string $fax;

    #[Optional]
    public ?string $mobile;

    #[Optional]
    public ?string $nic;

    #[Optional]
    public ?string $notes;

    #[Optional]
    public ?string $phone;

    #[Optional]
    public ?string $siren;

    /** @var list<string>|null $tags */
    #[Optional(list: 'string')]
    public ?array $tags;

    #[Optional('tva_number')]
    public ?string $tvaNumber;

    #[Optional]
    public ?string $website;

    #[Optional('zip_code')]
    public ?string $zipCode;

    /**
     * `new ClientUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClientUpdateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClientUpdateParams)->withName(...)
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
     * @param list<string>|null $tags
     */
    public static function with(
        string $name,
        ?string $address = null,
        ?string $addressComplement = null,
        ?string $addressEnd = null,
        ?string $analyticalCode = null,
        ?string $category = null,
        ?string $city = null,
        ?string $clientCode = null,
        ?string $country = null,
        ?string $description = null,
        ?string $email = null,
        ?string $fax = null,
        ?string $mobile = null,
        ?string $nic = null,
        ?string $notes = null,
        ?string $phone = null,
        ?string $siren = null,
        ?array $tags = null,
        ?string $tvaNumber = null,
        ?string $website = null,
        ?string $zipCode = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $address && $self['address'] = $address;
        null !== $addressComplement && $self['addressComplement'] = $addressComplement;
        null !== $addressEnd && $self['addressEnd'] = $addressEnd;
        null !== $analyticalCode && $self['analyticalCode'] = $analyticalCode;
        null !== $category && $self['category'] = $category;
        null !== $city && $self['city'] = $city;
        null !== $clientCode && $self['clientCode'] = $clientCode;
        null !== $country && $self['country'] = $country;
        null !== $description && $self['description'] = $description;
        null !== $email && $self['email'] = $email;
        null !== $fax && $self['fax'] = $fax;
        null !== $mobile && $self['mobile'] = $mobile;
        null !== $nic && $self['nic'] = $nic;
        null !== $notes && $self['notes'] = $notes;
        null !== $phone && $self['phone'] = $phone;
        null !== $siren && $self['siren'] = $siren;
        null !== $tags && $self['tags'] = $tags;
        null !== $tvaNumber && $self['tvaNumber'] = $tvaNumber;
        null !== $website && $self['website'] = $website;
        null !== $zipCode && $self['zipCode'] = $zipCode;

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

    public function withAddress(string $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    public function withAddressComplement(string $addressComplement): self
    {
        $self = clone $this;
        $self['addressComplement'] = $addressComplement;

        return $self;
    }

    public function withAddressEnd(string $addressEnd): self
    {
        $self = clone $this;
        $self['addressEnd'] = $addressEnd;

        return $self;
    }

    public function withAnalyticalCode(string $analyticalCode): self
    {
        $self = clone $this;
        $self['analyticalCode'] = $analyticalCode;

        return $self;
    }

    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    public function withCity(string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    public function withClientCode(string $clientCode): self
    {
        $self = clone $this;
        $self['clientCode'] = $clientCode;

        return $self;
    }

    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    public function withFax(string $fax): self
    {
        $self = clone $this;
        $self['fax'] = $fax;

        return $self;
    }

    public function withMobile(string $mobile): self
    {
        $self = clone $this;
        $self['mobile'] = $mobile;

        return $self;
    }

    public function withNic(string $nic): self
    {
        $self = clone $this;
        $self['nic'] = $nic;

        return $self;
    }

    public function withNotes(string $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

        return $self;
    }

    public function withPhone(string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    public function withSiren(string $siren): self
    {
        $self = clone $this;
        $self['siren'] = $siren;

        return $self;
    }

    /**
     * @param list<string> $tags
     */
    public function withTags(array $tags): self
    {
        $self = clone $this;
        $self['tags'] = $tags;

        return $self;
    }

    public function withTvaNumber(string $tvaNumber): self
    {
        $self = clone $this;
        $self['tvaNumber'] = $tvaNumber;

        return $self;
    }

    public function withWebsite(string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }

    public function withZipCode(string $zipCode): self
    {
        $self = clone $this;
        $self['zipCode'] = $zipCode;

        return $self;
    }
}
