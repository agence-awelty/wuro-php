<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\Users\UserGetByUidResponse;
use Wuro\Users\UserGetResponse;
use Wuro\Users\UserListInvitationsResponse;
use Wuro\Users\UserListNotificationsResponse;
use Wuro\Users\UserListPositionsResponse;
use Wuro\Users\UserUpdateParams\Address;
use Wuro\Users\UserUpdateParams\Gender;
use Wuro\Users\UserUpdateParams\Phone;
use Wuro\Users\UserUpdateResponse;

/**
 * @phpstan-import-type AddressShape from \Wuro\Users\UserUpdateParams\Address
 * @phpstan-import-type PhoneShape from \Wuro\Users\UserUpdateParams\Phone
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface UsersContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): UserGetResponse;

    /**
     * @api
     *
     * @param Address|AddressShape $address Adresse postale
     * @param string $avatar URL ou fichier base64 de l'avatar
     * @param \DateTimeInterface $birthdate Date de naissance
     * @param string $firstName Prénom
     * @param Gender|value-of<Gender> $gender Genre
     * @param string $lastName Nom de famille
     * @param Phone|PhoneShape $phone Téléphone principal
     * @param string $socialSecuNumber Numéro de sécurité sociale
     * @param string $title Civilité (MR, MME, etc.)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
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
        RequestOptions|array|null $requestOptions = null,
    ): UserUpdateResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listInvitations(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserListInvitationsResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listNotifications(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserListNotificationsResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserListPositionsResponse;

    /**
     * @api
     *
     * @param string $uid ID MongoDB ou adresse email de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveByUid(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserGetByUidResponse;
}
