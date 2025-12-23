<?php

declare(strict_types=1);

namespace Wuro\Users\UserUpdateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * Adresse postale.
 *
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

    #[Optional]
    public ?string $city;

    #[Optional]
    public ?string $country;

    #[Optional]
    public ?string $street;

    #[Optional('street_end')]
    public ?string $streetEnd;

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

    public function withCity(string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withStreet(string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }

    public function withStreetEnd(string $streetEnd): self
    {
        $self = clone $this;
        $self['streetEnd'] = $streetEnd;

        return $self;
    }

    public function withZipCode(string $zipCode): self
    {
        $self = clone $this;
        $self['zipCode'] = $zipCode;

        return $self;
    }
}
