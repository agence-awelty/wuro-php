<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\StatisticsRawContract;
use Wuro\Statistics\StatisticGetPaymentsResponse;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class StatisticsRawService implements StatisticsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Récupère les statistiques globales des paiements reçus.
     *
     * **Statistiques retournées:**
     * - Total des paiements par période
     * - Répartition par mode de paiement
     * - Évolution temporelle des encaissements
     * - Moyenne des paiements
     *
     * **Filtres disponibles:**
     * - Période (minDate, maxDate)
     * - Mode de paiement
     *
     * **Utilisation:**
     * - Tableau de bord financier
     * - Rapports de trésorerie
     * - Analyse des modes de paiement préférés
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StatisticGetPaymentsResponse>
     *
     * @throws APIException
     */
    public function retrievePayments(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'statistics/payments',
            options: $requestOptions,
            convert: StatisticGetPaymentsResponse::class,
        );
    }
}
