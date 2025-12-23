<?php

declare(strict_types=1);

namespace Wuro\Users;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Users\User\Address;
use Wuro\Users\User\Gender;
use Wuro\Users\User\Phone;
use Wuro\Users\User\State;

/**
 * @phpstan-import-type AddressShape from \Wuro\Users\User\Address
 * @phpstan-import-type PhoneShape from \Wuro\Users\User\Phone
 *
 * @phpstan-type UserShape = array{
 *   _id?: string|null,
 *   address?: null|Address|AddressShape,
 *   avatar?: string|null,
 *   birthdate?: \DateTimeInterface|null,
 *   createdAt?: \DateTimeInterface|null,
 *   email?: string|null,
 *   firstName?: string|null,
 *   gender?: null|Gender|value-of<Gender>,
 *   lastName?: string|null,
 *   phone?: null|Phone|PhoneShape,
 *   positions?: list<string>|null,
 *   state?: null|State|value-of<State>,
 *   termsOfSaleSignature?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class User implements BaseModel
{
    /** @use SdkModel<UserShape> */
    use SdkModel;

    /**
     * Unique identifier for the user.
     */
    #[Optional]
    public ?string $_id;

    #[Optional]
    public ?Address $address;

    /**
     * URL to user's avatar.
     */
    #[Optional]
    public ?string $avatar;

    /**
     * User's birthdate.
     */
    #[Optional]
    public ?\DateTimeInterface $birthdate;

    /**
     * Date when user was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * User's email address.
     */
    #[Optional]
    public ?string $email;

    /**
     * User's first name.
     */
    #[Optional('first_name')]
    public ?string $firstName;

    /**
     * User's gender.
     *
     * @var value-of<Gender>|null $gender
     */
    #[Optional(enum: Gender::class, nullable: true)]
    public ?string $gender;

    /**
     * User's last name.
     */
    #[Optional('last_name')]
    public ?string $lastName;

    #[Optional]
    public ?Phone $phone;

    /**
     * List of positions associated with the user.
     *
     * @var list<string>|null $positions
     */
    #[Optional(list: 'string')]
    public ?array $positions;

    /**
     * User's state.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Date when user accepted terms of sale.
     */
    #[Optional('terms_of_sale_signature')]
    public ?\DateTimeInterface $termsOfSaleSignature;

    /**
     * Date when user was last updated.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Address|AddressShape|null $address
     * @param Gender|value-of<Gender>|null $gender
     * @param Phone|PhoneShape|null $phone
     * @param list<string>|null $positions
     * @param State|value-of<State>|null $state
     */
    public static function with(
        ?string $_id = null,
        Address|array|null $address = null,
        ?string $avatar = null,
        ?\DateTimeInterface $birthdate = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $email = null,
        ?string $firstName = null,
        Gender|string|null $gender = null,
        ?string $lastName = null,
        Phone|array|null $phone = null,
        ?array $positions = null,
        State|string|null $state = null,
        ?\DateTimeInterface $termsOfSaleSignature = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $address && $self['address'] = $address;
        null !== $avatar && $self['avatar'] = $avatar;
        null !== $birthdate && $self['birthdate'] = $birthdate;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $email && $self['email'] = $email;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $gender && $self['gender'] = $gender;
        null !== $lastName && $self['lastName'] = $lastName;
        null !== $phone && $self['phone'] = $phone;
        null !== $positions && $self['positions'] = $positions;
        null !== $state && $self['state'] = $state;
        null !== $termsOfSaleSignature && $self['termsOfSaleSignature'] = $termsOfSaleSignature;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Unique identifier for the user.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * @param Address|AddressShape $address
     */
    public function withAddress(Address|array $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    /**
     * URL to user's avatar.
     */
    public function withAvatar(string $avatar): self
    {
        $self = clone $this;
        $self['avatar'] = $avatar;

        return $self;
    }

    /**
     * User's birthdate.
     */
    public function withBirthdate(\DateTimeInterface $birthdate): self
    {
        $self = clone $this;
        $self['birthdate'] = $birthdate;

        return $self;
    }

    /**
     * Date when user was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * User's email address.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * User's first name.
     */
    public function withFirstName(string $firstName): self
    {
        $self = clone $this;
        $self['firstName'] = $firstName;

        return $self;
    }

    /**
     * User's gender.
     *
     * @param Gender|value-of<Gender>|null $gender
     */
    public function withGender(Gender|string|null $gender): self
    {
        $self = clone $this;
        $self['gender'] = $gender;

        return $self;
    }

    /**
     * User's last name.
     */
    public function withLastName(string $lastName): self
    {
        $self = clone $this;
        $self['lastName'] = $lastName;

        return $self;
    }

    /**
     * @param Phone|PhoneShape $phone
     */
    public function withPhone(Phone|array $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    /**
     * List of positions associated with the user.
     *
     * @param list<string> $positions
     */
    public function withPositions(array $positions): self
    {
        $self = clone $this;
        $self['positions'] = $positions;

        return $self;
    }

    /**
     * User's state.
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
     * Date when user accepted terms of sale.
     */
    public function withTermsOfSaleSignature(
        \DateTimeInterface $termsOfSaleSignature
    ): self {
        $self = clone $this;
        $self['termsOfSaleSignature'] = $termsOfSaleSignature;

        return $self;
    }

    /**
     * Date when user was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
