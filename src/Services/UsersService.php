<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\UsersContract;
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
final class UsersService implements UsersContract
{
    /**
     * @api
     */
    public UsersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UsersRawService($client);
    }

    /**
     * @api
     *
     * Retourne les informations de l'utilisateur actuellement authentifié.
     * Utile pour obtenir le profil de l'utilisateur après connexion.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): UserGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
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
    ): UserUpdateResponse {
        $params = Util::removeNulls(
            [
                'address' => $address,
                'avatar' => $avatar,
                'birthdate' => $birthdate,
                'firstName' => $firstName,
                'gender' => $gender,
                'lastName' => $lastName,
                'personalEmail' => $personalEmail,
                'personalPhoneFixe' => $personalPhoneFixe,
                'phone' => $phone,
                'professionalEmail' => $professionalEmail,
                'professionalPhone' => $professionalPhone,
                'professionalPhoneFixe' => $professionalPhoneFixe,
                'socialSecuNumber' => $socialSecuNumber,
                'title' => $title,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function deactivate(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deactivate($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function listInvitations(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserListInvitationsResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listInvitations($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function listNotifications(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserListNotificationsResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listNotifications($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserListPositionsResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listPositions($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function retrieveByUid(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): UserGetByUidResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveByUid($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
