<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\OrderContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class OrderService implements OrderContract
{
    /**
     * @api
     */
    public OrderRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new OrderRawService($client);
    }

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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrievePaymentInfos(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrievePaymentInfos($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
