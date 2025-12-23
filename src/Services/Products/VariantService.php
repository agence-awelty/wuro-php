<?php

declare(strict_types=1);

namespace Wuro\Services\Products;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Products\VariantContract;

final class VariantService implements VariantContract
{
    /**
     * @api
     */
    public VariantRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new VariantRawService($client);
    }

    /**
     * @api
     *
     * Crée une nouvelle variante pour un produit existant.
     *
     * **Exemples de variantes:**
     * - Tailles : S, M, L, XL
     * - Couleurs : Rouge, Bleu, Vert
     * - Options : Avec option A, Sans option A
     *
     * **Propriétés personnalisables:**
     * - Prix spécifique à la variante
     * - Stock propre à la variante
     * - Référence distincte
     *
     * **Événement déclenché:** CREATE_PRODUCT_VARIANT
     *
     * @param string $uid Identifiant unique du produit parent
     * @param array{nbAlert?: float, nbMin?: float, nbStock?: float} $stock
     *
     * @throws APIException
     */
    public function create(
        string $uid,
        ?float $buyingPrice = null,
        ?string $name = null,
        mixed $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        ?array $stock = null,
        ?float $tvaRate = null,
        ?RequestOptions $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            [
                'buyingPrice' => $buyingPrice,
                'name' => $name,
                'options' => $options,
                'priceHt' => $priceHt,
                'reference' => $reference,
                'sku' => $sku,
                'stock' => $stock,
                'tvaRate' => $tvaRate,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les détails d'une variante de produit spécifique.
     *
     * @param string $uid Identifiant unique de la variante
     * @param string $productID Identifiant unique du produit parent
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        string $productID,
        ?RequestOptions $requestOptions = null
    ): mixed {
        $params = Util::removeNulls(['productID' => $productID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour une variante de produit existante.
     *
     * **Modifications possibles:**
     * - Prix de la variante
     * - Stock
     * - Référence
     * - Attributs de la variante
     *
     * **Événement déclenché:** UPDATE_PRODUCT_VARIANT
     *
     * @param string $uid Path param: Identifiant unique de la variante
     * @param string $productID Path param: Identifiant unique du produit parent
     * @param float $buyingPrice Body param:
     * @param string $name Body param:
     * @param mixed $options Body param:
     * @param float $priceHt Body param:
     * @param string $reference Body param:
     * @param string $sku Body param:
     * @param array{
     *   nbAlert?: float, nbMin?: float, nbStock?: float
     * } $stock Body param:
     * @param float $tvaRate Body param:
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        string $productID,
        ?float $buyingPrice = null,
        ?string $name = null,
        mixed $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        ?array $stock = null,
        ?float $tvaRate = null,
        ?RequestOptions $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            [
                'productID' => $productID,
                'buyingPrice' => $buyingPrice,
                'name' => $name,
                'options' => $options,
                'priceHt' => $priceHt,
                'reference' => $reference,
                'sku' => $sku,
                'stock' => $stock,
                'tvaRate' => $tvaRate,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère la liste de toutes les variantes de produits de l'entreprise.
     *
     * **Concept de variante:**
     * - Une variante est une déclinaison d'un produit (taille, couleur, etc.)
     * - Chaque variante peut avoir son propre prix et stock
     * - Les variantes héritent des propriétés du produit parent
     *
     * **Utilisation:**
     * - Gestion des déclinaisons produit
     * - Suivi du stock par variante
     *
     * @throws APIException
     */
    public function list(?RequestOptions $requestOptions = null): mixed
    {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supprime une variante de produit.
     *
     * **Attention:**
     * - Cette opération est irréversible
     * - La variante ne sera plus disponible à la vente
     *
     * **Événement déclenché:** DELETE_PRODUCT_VARIANT
     *
     * @param string $uid Identifiant unique de la variante
     * @param string $productID Identifiant unique du produit parent
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        string $productID,
        ?RequestOptions $requestOptions = null
    ): mixed {
        $params = Util::removeNulls(['productID' => $productID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
