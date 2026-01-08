<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\UsersRawContract;
use Wuro\Users\UserGetByUidResponse;
use Wuro\Users\UserGetResponse;
use Wuro\Users\UserListInvitationsResponse;
use Wuro\Users\UserListNotificationsResponse;
use Wuro\Users\UserListPositionsResponse;
use Wuro\Users\UserUpdateParams;
use Wuro\Users\UserUpdateParams\Address;
use Wuro\Users\UserUpdateParams\Gender;
use Wuro\Users\UserUpdateParams\Phone;
use Wuro\Users\UserUpdateResponse;

/**
 * @phpstan-import-type AddressShape from \Wuro\Users\UserUpdateParams\Address
 * @phpstan-import-type PhoneShape from \Wuro\Users\UserUpdateParams\Phone
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class UsersRawService implements UsersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retourne les informations de l'utilisateur actuellement authentifié.
     * Utile pour obtenir le profil de l'utilisateur après connexion.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'user',
            options: $requestOptions,
            convert: UserGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Met à jour les informations d'un utilisateur.
     *
     * **Restrictions:**
     * - L'email ne peut pas être modifié via cette route
     * - Le mot de passe ne peut pas être modifié via cette route (utiliser /auth/password/reset)
     * - Déclenche un événement UPDATE_USER
     *
     * @param array{
     *   address?: Address|AddressShape,
     *   avatar?: string,
     *   birthdate?: \DateTimeInterface,
     *   firstName?: string,
     *   gender?: Gender|value-of<Gender>,
     *   lastName?: string,
     *   personalEmail?: string,
     *   personalPhoneFixe?: string,
     *   phone?: Phone|PhoneShape,
     *   professionalEmail?: string,
     *   professionalPhone?: string,
     *   professionalPhoneFixe?: string,
     *   socialSecuNumber?: string,
     *   title?: string,
     * }|UserUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|UserUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['user/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: UserUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Désactive un utilisateur (soft delete).
     *
     * **Comportement:**
     * - L'état de l'utilisateur passe à 'inactive'
     * - L'utilisateur n'est pas supprimé de la base de données
     * - Déclenche un événement DELETE_USER
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function deactivate(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['user/%1$s', $uid],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Récupère la liste des invitations en attente pour un utilisateur.
     *
     * **Types d'invitations:**
     * - Invitation à rejoindre une entreprise
     * - Invitation à un projet ou équipe
     *
     * **États des invitations:**
     * - `pending` : En attente de réponse
     * - `accepted` : Acceptée
     * - `refused` : Refusée
     * - `expired` : Expirée
     *
     * **Utilisation:**
     * - Affichage des invitations en attente sur le dashboard utilisateur
     * - Gestion des demandes d'ajout à des entreprises
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListInvitationsResponse>
     *
     * @throws APIException
     */
    public function listInvitations(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['user/%1$s/invitations', $uid],
            options: $requestOptions,
            convert: UserListInvitationsResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste des notifications pour un utilisateur.
     *
     * **Types de notifications:**
     * - Factures en retard
     * - Devis en attente de validation
     * - Paiements reçus
     * - Invitations reçues
     * - Actions requises
     *
     * **Gestion des notifications:**
     * - Les notifications non lues sont marquées comme telles
     * - Les notifications peuvent être archivées
     *
     * **Utilisation:**
     * - Centre de notifications
     * - Badge de notifications non lues
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListNotificationsResponse>
     *
     * @throws APIException
     */
    public function listNotifications(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['user/%1$s/notifications', $uid],
            options: $requestOptions,
            convert: UserListNotificationsResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste des postes (positions) d'un utilisateur dans les différentes entreprises.
     *
     * **Informations retournées:**
     * - Liste des entreprises où l'utilisateur a un poste
     * - Type de poste dans chaque entreprise
     * - Droits associés à chaque poste
     *
     * **Utilisation:**
     * - Affichage du profil utilisateur multi-entreprises
     * - Vérification des accès utilisateur
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListPositionsResponse>
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['user/%1$s/positions', $uid],
            options: $requestOptions,
            convert: UserListPositionsResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les détails d'un utilisateur spécifique.
     *
     * **Paramètre uid:**
     * - Peut être un ObjectId MongoDB
     * - Ou une adresse email
     *
     * L'API détecte automatiquement le format.
     *
     * @param string $uid ID MongoDB ou adresse email de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetByUidResponse>
     *
     * @throws APIException
     */
    public function retrieveByUid(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['user/%1$s', $uid],
            options: $requestOptions,
            convert: UserGetByUidResponse::class,
        );
    }
}
