<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Companies\CompanyConfirmDomainResponse;
use Wuro\Companies\CompanyCreateParams;
use Wuro\Companies\CompanyGetByIDResponse;
use Wuro\Companies\CompanyGetCgvResponse;
use Wuro\Companies\CompanyGetExtraInfosResponse;
use Wuro\Companies\CompanyGetResponse;
use Wuro\Companies\CompanyListPositionsResponse;
use Wuro\Companies\CompanyNewResponse;
use Wuro\Companies\CompanyUpdateResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\CompaniesRawContract;

final class CompaniesRawService implements CompaniesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Crée une nouvelle entreprise.
     *
     * **Comportement:**
     * - L'URL est rendue unique automatiquement si elle existe déjà
     * - Un CompanyApp est créé automatiquement avec des options par défaut
     * - Si créée via une application, une Application d'accès est automatiquement générée
     *
     * **Restrictions:**
     * - Ne peut pas être créée depuis une version API
     *
     * **Événement déclenché:** CREATE_COMPANY
     *
     * @param array{
     *   name: string,
     *   url: string,
     *   addresses?: list<array{
     *     city?: string, country?: string, street?: string, zipCode?: string
     *   }>,
     *   commercialCourt?: string,
     *   companyType?: string,
     *   email?: string,
     *   nafApe?: string,
     *   nic?: string,
     *   numRcs?: string,
     *   numTradeDirectory?: string,
     *   shareCapital?: float,
     *   siren?: string,
     *   siret?: string,
     *   tvaNumber?: string,
     *   website?: string,
     * }|CompanyCreateParams $params
     *
     * @return BaseResponse<CompanyNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CompanyCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = CompanyCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'company',
            body: (object) $parsed,
            options: $options,
            convert: CompanyNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Retourne les informations de l'entreprise associée à la requête authentifiée.
     *
     * @return BaseResponse<CompanyGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'company',
            options: $requestOptions,
            convert: CompanyGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Met à jour les informations d'une entreprise.
     *
     * **Restrictions:**
     * - Le domaine d'envoi d'email est automatiquement extrait de emailExpeditor
     *
     * **Événement déclenché:** UPDATE_COMPANY
     *
     * @return BaseResponse<CompanyUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['company/%1$s', $uid],
            options: $requestOptions,
            convert: CompanyUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime (désactive) une entreprise.
     *
     * **Restrictions:**
     * - L'utilisateur doit être administrateur de l'entreprise
     * - L'état passe à 'inactive' (soft delete)
     *
     * **Événement déclenché:** DELETE_COMPANY
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['company/%1$s', $uid],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Confirme la vérification du domaine personnalisé pour l'entreprise.
     *
     * **Prérequis:**
     * - Un email de confirmation a été envoyé via `/send-domain-confirm`
     * - L'utilisateur doit cliquer sur le lien de confirmation
     *
     * **Comportement:**
     * - Marque le domaine comme vérifié
     * - Active les fonctionnalités liées au domaine personnalisé (envoi d'emails, etc.)
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyConfirmDomainResponse>
     *
     * @throws APIException
     */
    public function confirmDomain(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['company/%1$s/domain-confirm', $uid],
            options: $requestOptions,
            convert: CompanyConfirmDomainResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste de tous les postes (positions) d'une entreprise.
     *
     * **Informations retournées:**
     * - Liste des postes avec utilisateur, type et droits
     * - Inclut les postes actifs et inactifs
     *
     * **Utilisation:**
     * - Administration des accès utilisateurs
     * - Gestion des droits et permissions
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyListPositionsResponse>
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['company/%1$s/positions', $uid],
            options: $requestOptions,
            convert: CompanyListPositionsResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les détails d'une entreprise spécifique.
     *
     * @param string $uid ID de l'entreprise
     *
     * @return BaseResponse<CompanyGetByIDResponse>
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['company/%1$s', $uid],
            options: $requestOptions,
            convert: CompanyGetByIDResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les conditions générales de vente (CGV) configurées pour l'entreprise.
     *
     * **Réponse:**
     * - `cgv` : Texte des CGV personnalisées
     * - `cgv_link` : Lien vers un document externe de CGV
     * - `cgv_wuro` : Indique si les CGV par défaut de Wuro sont utilisées
     *
     * **Utilisation:**
     * - Affichage sur les devis et factures
     * - Page de mentions légales
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyGetCgvResponse>
     *
     * @throws APIException
     */
    public function retrieveCgv(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['company/%1$s/cgv', $uid],
            options: $requestOptions,
            convert: CompanyGetCgvResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les informations complètes d'une entreprise, incluant les données Company et CompanyApp.
     *
     * **Informations retournées:**
     * - `company` : Données de l'entreprise (coordonnées, paramètres légaux, etc.)
     * - `companyApp` : Données applicatives (modules, quotas, configuration)
     *
     * **Utilisation:**
     * - Affichage complet des paramètres entreprise
     * - Administration et configuration
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyGetExtraInfosResponse>
     *
     * @throws APIException
     */
    public function retrieveExtraInfos(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['company/%1$s/extra-infos', $uid],
            options: $requestOptions,
            convert: CompanyGetExtraInfosResponse::class,
        );
    }
}
