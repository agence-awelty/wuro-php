<?php

declare(strict_types=1);

namespace Wuro\Users;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Users\UserUpdateParams\Address;
use Wuro\Users\UserUpdateParams\Gender;
use Wuro\Users\UserUpdateParams\Phone;

/**
 * Met à jour les informations d'un utilisateur.
 *
 * **Restrictions:**
 * - L'email ne peut pas être modifié via cette route
 * - Le mot de passe ne peut pas être modifié via cette route (utiliser /auth/password/reset)
 * - Déclenche un événement UPDATE_USER
 *
 * @see Wuro\Services\UsersService::update()
 *
 * @phpstan-import-type AddressShape from \Wuro\Users\UserUpdateParams\Address
 * @phpstan-import-type PhoneShape from \Wuro\Users\UserUpdateParams\Phone
 *
 * @phpstan-type UserUpdateParamsShape = array{
 *   address?: null|Address|AddressShape,
 *   avatar?: string|null,
 *   birthdate?: \DateTimeInterface|null,
 *   firstName?: string|null,
 *   gender?: null|Gender|value-of<Gender>,
 *   lastName?: string|null,
 *   personalEmail?: string|null,
 *   personalPhoneFixe?: string|null,
 *   phone?: null|Phone|PhoneShape,
 *   professionalEmail?: string|null,
 *   professionalPhone?: string|null,
 *   professionalPhoneFixe?: string|null,
 *   socialSecuNumber?: string|null,
 *   title?: string|null,
 * }
 */
final class UserUpdateParams implements BaseModel
{
    /** @use SdkModel<UserUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Adresse postale.
     */
    #[Optional]
    public ?Address $address;

    /**
     * URL ou fichier base64 de l'avatar.
     */
    #[Optional]
    public ?string $avatar;

    /**
     * Date de naissance.
     */
    #[Optional]
    public ?\DateTimeInterface $birthdate;

    /**
     * Prénom.
     */
    #[Optional('first_name')]
    public ?string $firstName;

    /**
     * Genre.
     *
     * @var value-of<Gender>|null $gender
     */
    #[Optional(enum: Gender::class)]
    public ?string $gender;

    /**
     * Nom de famille.
     */
    #[Optional('last_name')]
    public ?string $lastName;

    #[Optional('personal_email')]
    public ?string $personalEmail;

    #[Optional('personal_phone_fixe')]
    public ?string $personalPhoneFixe;

    /**
     * Téléphone principal.
     */
    #[Optional]
    public ?Phone $phone;

    #[Optional('professional_email')]
    public ?string $professionalEmail;

    #[Optional('professional_phone')]
    public ?string $professionalPhone;

    #[Optional('professional_phone_fixe')]
    public ?string $professionalPhoneFixe;

    /**
     * Numéro de sécurité sociale.
     */
    #[Optional('social_secu_number')]
    public ?string $socialSecuNumber;

    /**
     * Civilité (MR, MME, etc.).
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
     * @param Address|AddressShape|null $address
     * @param Gender|value-of<Gender>|null $gender
     * @param Phone|PhoneShape|null $phone
     */
    public static function with(
        Address|array|null $address = null,
        ?string $avatar = null,
        ?\DateTimeInterface $birthdate = null,
        ?string $firstName = null,
        Gender|string|null $gender = null,
        ?string $lastName = null,
        ?string $personalEmail = null,
        ?string $personalPhoneFixe = null,
        Phone|array|null $phone = null,
        ?string $professionalEmail = null,
        ?string $professionalPhone = null,
        ?string $professionalPhoneFixe = null,
        ?string $socialSecuNumber = null,
        ?string $title = null,
    ): self {
        $self = new self;

        null !== $address && $self['address'] = $address;
        null !== $avatar && $self['avatar'] = $avatar;
        null !== $birthdate && $self['birthdate'] = $birthdate;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $gender && $self['gender'] = $gender;
        null !== $lastName && $self['lastName'] = $lastName;
        null !== $personalEmail && $self['personalEmail'] = $personalEmail;
        null !== $personalPhoneFixe && $self['personalPhoneFixe'] = $personalPhoneFixe;
        null !== $phone && $self['phone'] = $phone;
        null !== $professionalEmail && $self['professionalEmail'] = $professionalEmail;
        null !== $professionalPhone && $self['professionalPhone'] = $professionalPhone;
        null !== $professionalPhoneFixe && $self['professionalPhoneFixe'] = $professionalPhoneFixe;
        null !== $socialSecuNumber && $self['socialSecuNumber'] = $socialSecuNumber;
        null !== $title && $self['title'] = $title;

        return $self;
    }

    /**
     * Adresse postale.
     *
     * @param Address|AddressShape $address
     */
    public function withAddress(Address|array $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    /**
     * URL ou fichier base64 de l'avatar.
     */
    public function withAvatar(string $avatar): self
    {
        $self = clone $this;
        $self['avatar'] = $avatar;

        return $self;
    }

    /**
     * Date de naissance.
     */
    public function withBirthdate(\DateTimeInterface $birthdate): self
    {
        $self = clone $this;
        $self['birthdate'] = $birthdate;

        return $self;
    }

    /**
     * Prénom.
     */
    public function withFirstName(string $firstName): self
    {
        $self = clone $this;
        $self['firstName'] = $firstName;

        return $self;
    }

    /**
     * Genre.
     *
     * @param Gender|value-of<Gender> $gender
     */
    public function withGender(Gender|string $gender): self
    {
        $self = clone $this;
        $self['gender'] = $gender;

        return $self;
    }

    /**
     * Nom de famille.
     */
    public function withLastName(string $lastName): self
    {
        $self = clone $this;
        $self['lastName'] = $lastName;

        return $self;
    }

    public function withPersonalEmail(string $personalEmail): self
    {
        $self = clone $this;
        $self['personalEmail'] = $personalEmail;

        return $self;
    }

    public function withPersonalPhoneFixe(string $personalPhoneFixe): self
    {
        $self = clone $this;
        $self['personalPhoneFixe'] = $personalPhoneFixe;

        return $self;
    }

    /**
     * Téléphone principal.
     *
     * @param Phone|PhoneShape $phone
     */
    public function withPhone(Phone|array $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    public function withProfessionalEmail(string $professionalEmail): self
    {
        $self = clone $this;
        $self['professionalEmail'] = $professionalEmail;

        return $self;
    }

    public function withProfessionalPhone(string $professionalPhone): self
    {
        $self = clone $this;
        $self['professionalPhone'] = $professionalPhone;

        return $self;
    }

    public function withProfessionalPhoneFixe(
        string $professionalPhoneFixe
    ): self {
        $self = clone $this;
        $self['professionalPhoneFixe'] = $professionalPhoneFixe;

        return $self;
    }

    /**
     * Numéro de sécurité sociale.
     */
    public function withSocialSecuNumber(string $socialSecuNumber): self
    {
        $self = clone $this;
        $self['socialSecuNumber'] = $socialSecuNumber;

        return $self;
    }

    /**
     * Civilité (MR, MME, etc.).
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
