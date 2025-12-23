<?php

declare(strict_types=1);

namespace Wuro\Services\Companies;

use Wuro\Client;
use Wuro\Companies\AppInfos\CompanyApp;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Companies\AppInfosRawContract;

final class AppInfosRawService implements AppInfosRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @return BaseResponse<CompanyApp>
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'company/app-infos',
            options: $requestOptions,
            convert: CompanyApp::class,
        );
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
     * @return BaseResponse<CompanyApp>
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
            path: ['company/%1$s/app-infos', $uid],
            options: $requestOptions,
            convert: CompanyApp::class,
        );
    }
}
