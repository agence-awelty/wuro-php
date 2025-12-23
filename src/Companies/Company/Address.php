<?php

declare(strict_types=1);

namespace Wuro\Companies\Company;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type AddressShape = array{
 *   city?: string|null,
 *   country?: string|null,
 *   street?: string|null,
 *   streetEnd?: string|null,
 *   zipCode?: string|null,
 * }
 */
final class Address implements BaseModel
{
    /** @use SdkModel<AddressShape> */
    use SdkModel;

    /**
     * City.
     */
    #[Optional]
    public ?string $city;

    /**
     * Country.
     */
    #[Optional]
    public ?string $country;

    /**
     * Street address.
     */
    #[Optional]
    public ?string $street;

    /**
     * Additional street address information.
     */
    #[Optional('street_end')]
    public ?string $streetEnd;

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
     */
    public static function with(
        ?string $city = null,
        ?string $country = null,
        ?string $street = null,
        ?string $streetEnd = null,
        ?string $zipCode = null,
    ): self {
        $self = new self;

        null !== $city && $self['city'] = $city;
        null !== $country && $self['country'] = $country;
        null !== $street && $self['street'] = $street;
        null !== $streetEnd && $self['streetEnd'] = $streetEnd;
        null !== $zipCode && $self['zipCode'] = $zipCode;

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
     * Country.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Street address.
     */
    public function withStreet(string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }

    /**
     * Additional street address information.
     */
    public function withStreetEnd(string $streetEnd): self
    {
        $self = clone $this;
        $self['streetEnd'] = $streetEnd;

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
