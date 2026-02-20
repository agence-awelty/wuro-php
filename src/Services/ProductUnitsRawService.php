<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Conversion\ListOf;
use Wuro\Core\Exceptions\APIException;
use Wuro\ProductUnits\ProductUnitListResponseItem;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ProductUnitsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class ProductUnitsRawService implements ProductUnitsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @return BaseResponse<list<ProductUnitListResponseItem>>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'product-units',
            options: $requestOptions,
            convert: new ListOf(ProductUnitListResponseItem::class),
        );
    }
}
