<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\OrderRawContract;

final class OrderRawService implements OrderRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Récupère les informations de paiement associées à une commande.
     *
     * **Informations retournées:**
     * - URL de paiement (si applicable)
     * - Statut du paiement
     * - Historique des tentatives de paiement
     * - Détails de la transaction
     *
     * **Utilisation:**
     * - Affichage du statut de paiement au client
     * - Génération d'un nouveau lien de paiement si nécessaire
     *
     * @param string $uid Identifiant unique de la commande
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrievePaymentInfos(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['order/%1$s/payment-infos', $uid],
            options: $requestOptions,
            convert: null,
        );
    }
}
