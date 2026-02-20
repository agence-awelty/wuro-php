<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\ProductUnits\ProductUnitListResponseItem;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ProductUnitsContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class ProductUnitsService implements ProductUnitsContract
{
    /**
     * @api
     */
    public ProductUnitsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ProductUnitsRawService($client);
    }

    /**
     * @api
     *
     * Récupère la liste des unités de mesure utilisables pour les produits.
     *
     * **Unités standard:**
     * - Pièce, Unité
     * - Heure, Jour, Mois
     * - Kilogramme, Litre, Mètre
     * - Forfait
     *
     * **Utilisation:**
     * - Sélection de l'unité lors de la création/modification d'un produit
     * - Affichage sur les devis et factures
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return list<ProductUnitListResponseItem>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): array {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }
}
