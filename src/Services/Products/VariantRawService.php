<?php

declare(strict_types=1);

namespace Wuro\Services\Products;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Products\Variant\VariantCreateParams;
use Wuro\Products\Variant\VariantCreateParams\Stock;
use Wuro\Products\Variant\VariantDeleteParams;
use Wuro\Products\Variant\VariantRetrieveParams;
use Wuro\Products\Variant\VariantUpdateParams;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Products\VariantRawContract;

/**
 * @phpstan-import-type StockShape from \Wuro\Products\Variant\VariantCreateParams\Stock
 * @phpstan-import-type StockShape from \Wuro\Products\Variant\VariantUpdateParams\Stock as StockShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class VariantRawService implements VariantRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   buyingPrice?: float,
     *   name?: string,
     *   options?: mixed,
     *   priceHt?: float,
     *   reference?: string,
     *   sku?: string,
     *   stock?: Stock|StockShape,
     *   tvaRate?: float,
     * }|VariantCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function create(
        string $uid,
        array|VariantCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VariantCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['product/%1$s/variant', $uid],
            body: (object) $parsed,
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Récupère les détails d'une variante de produit spécifique.
     *
     * @param string $uid Identifiant unique de la variante
     * @param array{productID: string}|VariantRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|VariantRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VariantRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $productID = $parsed['productID'];
        unset($parsed['productID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['product/%1$s/variant/%2$s', $productID, $uid],
            options: $options,
            convert: null,
        );
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
     * @param array{
     *   productID: string,
     *   buyingPrice?: float,
     *   name?: string,
     *   options?: mixed,
     *   priceHt?: float,
     *   reference?: string,
     *   sku?: string,
     *   stock?: VariantUpdateParams\Stock|StockShape1,
     *   tvaRate?: float,
     * }|VariantUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|VariantUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VariantUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $productID = $parsed['productID'];
        unset($parsed['productID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['product/%1$s/variant/%2$s', $productID, $uid],
            body: (object) array_diff_key($parsed, array_flip(['productID'])),
            options: $options,
            convert: null,
        );
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'product-variants',
            options: $requestOptions,
            convert: null,
        );
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
     * @param array{productID: string}|VariantDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        array|VariantDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VariantDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $productID = $parsed['productID'];
        unset($parsed['productID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['product/%1$s/variant/%2$s', $productID, $uid],
            options: $options,
            convert: null,
        );
    }
}
