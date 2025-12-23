<?php

declare(strict_types=1);

namespace Wuro\Services\Companies;

use Wuro\Client;
use Wuro\Companies\AppInfos\CompanyApp;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Companies\AppInfosContract;

final class AppInfosService implements AppInfosContract
{
    /**
     * @api
     */
    public AppInfosRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AppInfosRawService($client);
    }

    /**
     * @api
     *
     * Récupère les informations applicatives (CompanyApp) de l'entreprise actuellement sélectionnée.
     *
     * **Informations retournées:**
     * - Configuration de l'application
     * - Modules activés
     * - Limites et quotas
     * - Paramètres de personnalisation
     *
     * @throws APIException
     */
    public function retrieve(?RequestOptions $requestOptions = null): CompanyApp
    {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les informations applicatives (CompanyApp) d'une entreprise spécifique.
     *
     * **Informations retournées:**
     * - Configuration de l'application
     * - Modules activés
     * - Limites et quotas
     * - Paramètres de personnalisation
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyApp {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveByID($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
