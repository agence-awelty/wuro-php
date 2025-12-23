<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Clients\ClientDeleteResponse;
use Wuro\Clients\ClientGetResponse;
use Wuro\Clients\ClientImportFromCsvResponse;
use Wuro\Clients\ClientListParams\State;
use Wuro\Clients\ClientListResponse;
use Wuro\Clients\ClientMergeResponse;
use Wuro\Clients\ClientNewResponse;
use Wuro\Clients\ClientUpdateResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ClientsContract;

final class ClientsService implements ClientsContract
{
    /**
     * @api
     */
    public ClientsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ClientsRawService($client);
    }

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
     * @param string $name Name of the client (required)
     * @param list<string> $tags
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $address = null,
        ?string $addressComplement = null,
        ?string $addressEnd = null,
        ?string $analyticalCode = null,
        ?string $category = null,
        ?string $city = null,
        ?string $clientCode = null,
        string $country = 'France',
        ?string $description = null,
        ?string $email = null,
        ?string $fax = null,
        ?string $mobile = null,
        ?string $nic = null,
        ?string $notes = null,
        ?string $phone = null,
        ?string $siren = null,
        ?array $tags = null,
        ?string $tvaNumber = null,
        ?string $website = null,
        ?string $zipCode = null,
        ?RequestOptions $requestOptions = null,
    ): ClientNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'address' => $address,
                'addressComplement' => $addressComplement,
                'addressEnd' => $addressEnd,
                'analyticalCode' => $analyticalCode,
                'category' => $category,
                'city' => $city,
                'clientCode' => $clientCode,
                'country' => $country,
                'description' => $description,
                'email' => $email,
                'fax' => $fax,
                'mobile' => $mobile,
                'nic' => $nic,
                'notes' => $notes,
                'phone' => $phone,
                'siren' => $siren,
                'tags' => $tags,
                'tvaNumber' => $tvaNumber,
                'website' => $website,
                'zipCode' => $zipCode,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $populate Relations à inclure
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null
    ): ClientGetResponse {
        $params = Util::removeNulls(['populate' => $populate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $name Name of the client (required)
     * @param list<string> $tags
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        string $name,
        ?string $address = null,
        ?string $addressComplement = null,
        ?string $addressEnd = null,
        ?string $analyticalCode = null,
        ?string $category = null,
        ?string $city = null,
        ?string $clientCode = null,
        string $country = 'France',
        ?string $description = null,
        ?string $email = null,
        ?string $fax = null,
        ?string $mobile = null,
        ?string $nic = null,
        ?string $notes = null,
        ?string $phone = null,
        ?string $siren = null,
        ?array $tags = null,
        ?string $tvaNumber = null,
        ?string $website = null,
        ?string $zipCode = null,
        ?RequestOptions $requestOptions = null,
    ): ClientUpdateResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'address' => $address,
                'addressComplement' => $addressComplement,
                'addressEnd' => $addressEnd,
                'analyticalCode' => $analyticalCode,
                'category' => $category,
                'city' => $city,
                'clientCode' => $clientCode,
                'country' => $country,
                'description' => $description,
                'email' => $email,
                'fax' => $fax,
                'mobile' => $mobile,
                'nic' => $nic,
                'notes' => $notes,
                'phone' => $phone,
                'siren' => $siren,
                'tags' => $tags,
                'tvaNumber' => $tvaNumber,
                'website' => $website,
                'zipCode' => $zipCode,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param int $limit Nombre maximum de clients à retourner
     * @param string $search Recherche textuelle dans nom, email, téléphone, code client
     * @param int $skip Nombre de clients à ignorer (pagination)
     * @param string $sort Champ et direction de tri (ex. "name:1" pour tri alphabétique)
     * @param 'active'|'inactive'|State $state Filtrer par état (active = visible, inactive = archivé)
     *
     * @throws APIException
     */
    public function list(
        int $limit = 20,
        ?string $search = null,
        int $skip = 0,
        ?string $sort = null,
        string|State|null $state = null,
        ?RequestOptions $requestOptions = null,
    ): ClientListResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'search' => $search,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): ClientDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $file Fichier CSV à importer
     *
     * @throws APIException
     */
    public function importFromCsv(
        ?string $file = null,
        ?RequestOptions $requestOptions = null
    ): ClientImportFromCsvResponse {
        $params = Util::removeNulls(['file' => $file]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->importFromCsv(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $source ID du client à fusionner (sera supprimé)
     * @param string $target ID du client cible (recevra les documents)
     *
     * @throws APIException
     */
    public function merge(
        string $source,
        string $target,
        ?RequestOptions $requestOptions = null
    ): ClientMergeResponse {
        $params = Util::removeNulls(['source' => $source, 'target' => $target]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->merge(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
