<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Clients\ClientCreateParams;
use Wuro\Clients\ClientDeleteResponse;
use Wuro\Clients\ClientGetResponse;
use Wuro\Clients\ClientImportFromCsvParams;
use Wuro\Clients\ClientImportFromCsvResponse;
use Wuro\Clients\ClientListParams;
use Wuro\Clients\ClientListParams\State;
use Wuro\Clients\ClientListResponse;
use Wuro\Clients\ClientMergeParams;
use Wuro\Clients\ClientMergeResponse;
use Wuro\Clients\ClientNewResponse;
use Wuro\Clients\ClientRetrieveParams;
use Wuro\Clients\ClientUpdateParams;
use Wuro\Clients\ClientUpdateResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ClientsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class ClientsRawService implements ClientsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Crée un nouveau client pour l'entreprise.
     *
     * ## Champs obligatoires
     *
     * Seul le nom (`name`) est obligatoire. Tous les autres champs sont optionnels.
     *
     * ## Code client automatique
     *
     * Si vous ne fournissez pas de code client (`code`), un code unique sera généré automatiquement.
     *
     * ## Validation TVA
     *
     * Si vous fournissez un numéro de TVA intracommunautaire, celui-ci sera validé.
     *
     * ## Événement déclenché
     *
     * Un événement `CREATE_CLIENT` est émis après la création.
     *
     * @param array{
     *   name: string,
     *   address?: string,
     *   addressComplement?: string,
     *   addressEnd?: string,
     *   analyticalCode?: string,
     *   category?: string,
     *   city?: string,
     *   clientCode?: string,
     *   country?: string,
     *   description?: string,
     *   email?: string,
     *   fax?: string,
     *   mobile?: string,
     *   nic?: string,
     *   notes?: string,
     *   phone?: string,
     *   siren?: string,
     *   tags?: list<string>,
     *   tvaNumber?: string,
     *   website?: string,
     *   zipCode?: string,
     * }|ClientCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ClientCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ClientCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'client',
            body: (object) $parsed,
            options: $options,
            convert: ClientNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les informations détaillées d'un client par son identifiant.
     *
     * Les informations incluent :
     * - Coordonnées (nom, adresse, email, téléphone)
     * - Informations fiscales (SIRET, TVA intracommunautaire)
     * - Conditions commerciales (remise par défaut, délai de paiement)
     * - Statistiques (CA, nombre de factures, etc.)
     *
     * @param string $uid Identifiant unique du client
     * @param array{populate?: string}|ClientRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|ClientRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ClientRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['client/%1$s', $uid],
            query: $parsed,
            options: $options,
            convert: ClientGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Met à jour les informations d'un client existant.
     *
     * Vous pouvez modifier :
     * - Les coordonnées (nom, adresse, contacts)
     * - Les informations fiscales (SIRET, TVA)
     * - Les conditions commerciales
     * - L'état (active/inactive pour archiver)
     *
     * ## Événement déclenché
     *
     * Un événement `UPDATE_CLIENT` est émis après la mise à jour.
     *
     * @param string $uid Identifiant unique du client
     * @param array{
     *   name: string,
     *   address?: string,
     *   addressComplement?: string,
     *   addressEnd?: string,
     *   analyticalCode?: string,
     *   category?: string,
     *   city?: string,
     *   clientCode?: string,
     *   country?: string,
     *   description?: string,
     *   email?: string,
     *   fax?: string,
     *   mobile?: string,
     *   nic?: string,
     *   notes?: string,
     *   phone?: string,
     *   siren?: string,
     *   tags?: list<string>,
     *   tvaNumber?: string,
     *   website?: string,
     *   zipCode?: string,
     * }|ClientUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ClientUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ClientUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['client/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: ClientUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste de tous les clients de l'entreprise avec pagination, tri et recherche.
     *
     * ## Recherche
     *
     * Le paramètre `search` permet une recherche textuelle dans :
     * - Le nom du client
     * - L'email
     * - Le numéro de téléphone
     * - Le code client
     *
     * ## Tri
     *
     * Utilisez `sort` avec le format `champ:direction` où direction est 1 (asc) ou -1 (desc).
     * Exemples : "name:1", "createdAt:-1"
     *
     * @param array{
     *   limit?: int,
     *   search?: string,
     *   skip?: int,
     *   sort?: string,
     *   state?: State|value-of<State>,
     * }|ClientListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ClientListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ClientListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'clients',
            query: $parsed,
            options: $options,
            convert: ClientListResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime un client (soft delete).
     *
     * Le client passe en état "inactive" et n'apparaît plus dans les listes standards.
     * Les documents existants (factures, devis) associés à ce client sont conservés.
     *
     * ## Événement déclenché
     *
     * Un événement `DELETE_CLIENT` est émis après la suppression.
     *
     * @param string $uid Identifiant unique du client
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['client/%1$s', $uid],
            options: $requestOptions,
            convert: ClientDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Importe une liste de clients à partir d'un fichier CSV.
     *
     * **Format du fichier CSV:**
     * - Le fichier doit être encodé en UTF-8
     * - La première ligne doit contenir les en-têtes des colonnes
     * - Séparateur de colonnes : point-virgule (;) ou virgule (,)
     *
     * **Colonnes supportées:**
     * - `name` : Nom du client (obligatoire)
     * - `email` : Adresse email
     * - `phone` : Numéro de téléphone
     * - `address` : Adresse postale
     * - `city` : Ville
     * - `zip_code` : Code postal
     * - `country` : Pays
     * - `code` : Code client
     * - `siren` : Numéro SIREN
     * - `tva_intracom` : Numéro de TVA intracommunautaire
     *
     * **Comportement:**
     * - Les clients existants (basé sur l'email ou le code) sont mis à jour
     * - Les nouveaux clients sont créés
     * - Un rapport d'import est retourné
     *
     * **Télécharger un modèle:**
     * - GET /files/clients.csv pour obtenir un fichier modèle
     *
     * @param array{file?: string}|ClientImportFromCsvParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientImportFromCsvResponse>
     *
     * @throws APIException
     */
    public function importFromCsv(
        array|ClientImportFromCsvParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ClientImportFromCsvParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'clients/csv',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: ClientImportFromCsvResponse::class,
        );
    }

    /**
     * @api
     *
     * Fusionne deux fiches clients en une seule.
     *
     * **Fonctionnement:**
     * - Le client `source` est fusionné dans le client `target`
     * - Toutes les factures, devis et documents du client source sont transférés au client cible
     * - Le client source est supprimé après la fusion
     *
     * **Transfert des données:**
     * - Factures et devis
     * - Historique des paiements
     * - Notes et commentaires
     * - Interlocuteurs
     *
     * **Attention:**
     * - Cette opération est irréversible
     * - Les informations du client source qui diffèrent ne sont pas copiées (seuls les documents sont transférés)
     *
     * **Événement déclenché:** MERGE_CLIENT
     *
     * @param array{source: string, target: string}|ClientMergeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientMergeResponse>
     *
     * @throws APIException
     */
    public function merge(
        array|ClientMergeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ClientMergeParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'clients/merge',
            body: (object) $parsed,
            options: $options,
            convert: ClientMergeResponse::class,
        );
    }
}
