<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\StatisticsContract;
use Wuro\Statistics\StatisticGetPaymentsResponse;

final class StatisticsService implements StatisticsContract
{
    /**
     * @api
     */
    public StatisticsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new StatisticsRawService($client);
    }

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
     * @throws APIException
     */
    public function retrievePayments(
        ?RequestOptions $requestOptions = null
    ): StatisticGetPaymentsResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrievePayments(requestOptions: $requestOptions);

        return $response->parse();
    }
}
