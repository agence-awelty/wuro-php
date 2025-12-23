<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Companies\CompanyConfirmDomainResponse;
use Wuro\Companies\CompanyGetByIDResponse;
use Wuro\Companies\CompanyGetCgvResponse;
use Wuro\Companies\CompanyGetExtraInfosResponse;
use Wuro\Companies\CompanyGetResponse;
use Wuro\Companies\CompanyListPositionsResponse;
use Wuro\Companies\CompanyNewResponse;
use Wuro\Companies\CompanyUpdateResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\CompaniesContract;
use Wuro\Services\Companies\AppInfosService;
use Wuro\Services\Companies\PositionService;

final class CompaniesService implements CompaniesContract
{
    /**
     * @api
     */
    public CompaniesRawService $raw;

    /**
     * @api
     */
    public AppInfosService $appInfos;

    /**
     * @api
     */
    public PositionService $position;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CompaniesRawService($client);
        $this->appInfos = new AppInfosService($client);
        $this->position = new PositionService($client);
    }

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
     * @param string $name Nom de l'entreprise (obligatoire)
     * @param string $url URL unique pour l'entreprise (obligatoire)
     * @param list<array{
     *   city?: string, country?: string, street?: string, zipCode?: string
     * }> $addresses
     * @param string $commercialCourt Tribunal de commerce
     * @param string $companyType ID du type d'entreprise (SARL, SAS, etc.)
     * @param string $email Email principal de l'entreprise
     * @param string $nafApe Code NAF/APE
     * @param string $nic Code NIC
     * @param string $numRcs Numéro d'inscription au RCS
     * @param string $numTradeDirectory Numéro au répertoire des métiers
     * @param float $shareCapital Capital social
     * @param string $siren Numéro SIREN (9 chiffres)
     * @param string $siret Numéro SIRET (14 chiffres)
     * @param string $tvaNumber Numéro de TVA intracommunautaire
     * @param string $website Site web de l'entreprise
     *
     * @throws APIException
     */
    public function create(
        string $name,
        string $url,
        ?array $addresses = null,
        ?string $commercialCourt = null,
        ?string $companyType = null,
        ?string $email = null,
        ?string $nafApe = null,
        ?string $nic = null,
        ?string $numRcs = null,
        ?string $numTradeDirectory = null,
        ?float $shareCapital = null,
        ?string $siren = null,
        ?string $siret = null,
        ?string $tvaNumber = null,
        ?string $website = null,
        ?RequestOptions $requestOptions = null,
    ): CompanyNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'url' => $url,
                'addresses' => $addresses,
                'commercialCourt' => $commercialCourt,
                'companyType' => $companyType,
                'email' => $email,
                'nafApe' => $nafApe,
                'nic' => $nic,
                'numRcs' => $numRcs,
                'numTradeDirectory' => $numTradeDirectory,
                'shareCapital' => $shareCapital,
                'siren' => $siren,
                'siret' => $siret,
                'tvaNumber' => $tvaNumber,
                'website' => $website,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retourne les informations de l'entreprise associée à la requête authentifiée.
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): CompanyGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function update(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyUpdateResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function confirmDomain(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyConfirmDomainResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->confirmDomain($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyListPositionsResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listPositions($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les détails d'une entreprise spécifique.
     *
     * @param string $uid ID de l'entreprise
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyGetByIDResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveByID($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function retrieveCgv(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyGetCgvResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveCgv($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function retrieveExtraInfos(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyGetExtraInfosResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveExtraInfos($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
