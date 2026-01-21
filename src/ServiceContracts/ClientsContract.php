<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Clients\ClientDeleteResponse;
use Wuro\Clients\ClientGetResponse;
use Wuro\Clients\ClientImportFromCsvResponse;
use Wuro\Clients\ClientListParams\State;
use Wuro\Clients\ClientListResponse;
use Wuro\Clients\ClientMergeResponse;
use Wuro\Clients\ClientNewResponse;
use Wuro\Clients\ClientUpdateResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ClientsContract
{
    /**
     * @api
     *
     * @param string $name Name of the client (required)
     * @param list<string> $tags
     * @param RequestOpts|null $requestOptions
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
        RequestOptions|array|null $requestOptions = null,
    ): ClientNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param string $populate Relations à inclure
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): ClientGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param string $name Name of the client (required)
     * @param list<string> $tags
     * @param RequestOpts|null $requestOptions
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
        RequestOptions|array|null $requestOptions = null,
    ): ClientUpdateResponse;

    /**
     * @api
     *
     * @param int $limit Nombre maximum de clients à retourner
     * @param string $search Recherche textuelle dans nom, email, téléphone, code client
     * @param int $skip Nombre de clients à ignorer (pagination)
     * @param string $sort Champ et direction de tri (ex. "name:1" pour tri alphabétique)
     * @param State|value-of<State> $state Filtrer par état (active = visible, inactive = archivé)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $limit = 20,
        ?string $search = null,
        int $skip = 0,
        ?string $sort = null,
        State|string|null $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): ClientListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): ClientDeleteResponse;

    /**
     * @api
     *
     * @param string $file Fichier CSV à importer
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function importFromCsv(
        ?string $file = null,
        RequestOptions|array|null $requestOptions = null
    ): ClientImportFromCsvResponse;

    /**
     * @api
     *
     * @param string $source ID du client à fusionner (sera supprimé)
     * @param string $target ID du client cible (recevra les documents)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function merge(
        string $source,
        string $target,
        RequestOptions|array|null $requestOptions = null,
    ): ClientMergeResponse;
}
