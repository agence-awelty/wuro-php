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
use Wuro\Users\UserUpdateParams\Gender;
use Wuro\Users\UserUpdateResponse;

interface UsersContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): UserGetResponse;

    /**
     * @api
     *
     * @param array{
     *   city?: string,
     *   country?: string,
     *   street?: string,
     *   streetEnd?: string,
     *   zipCode?: string,
     * } $address Adresse postale
     * @param string $avatar URL ou fichier base64 de l'avatar
     * @param string|\DateTimeInterface $birthdate Date de naissance
     * @param string $firstName Prénom
     * @param 'H'|'F'|'Other'|Gender $gender Genre
     * @param string $lastName Nom de famille
     * @param array{number?: string} $phone Téléphone principal
     * @param string $socialSecuNumber Numéro de sécurité sociale
     * @param string $title Civilité (MR, MME, etc.)
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?array $address = null,
        ?string $avatar = null,
        string|\DateTimeInterface|null $birthdate = null,
        ?string $firstName = null,
        string|Gender|null $gender = null,
        ?string $lastName = null,
        ?string $personalEmail = null,
        ?string $personalPhoneFixe = null,
        ?array $phone = null,
        ?string $professionalEmail = null,
        ?string $professionalPhone = null,
        ?string $professionalPhoneFixe = null,
        ?string $socialSecuNumber = null,
        ?string $title = null,
        ?RequestOptions $requestOptions = null,
    ): UserUpdateResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function deactivate(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     *
     * @throws APIException
     */
    public function listInvitations(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): UserListInvitationsResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     *
     * @throws APIException
     */
    public function listNotifications(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): UserListNotificationsResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): UserListPositionsResponse;

    /**
     * @api
     *
     * @param string $uid ID MongoDB ou adresse email de l'utilisateur
     *
     * @throws APIException
     */
    public function retrieveByUid(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): UserGetByUidResponse;
}
