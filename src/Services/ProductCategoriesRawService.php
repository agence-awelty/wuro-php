<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\ProductCategories\ProductCategory;
use Wuro\ProductCategories\ProductCategoryCreateParams;
use Wuro\ProductCategories\ProductCategoryListResponse;
use Wuro\ProductCategories\ProductCategoryUpdateParams;
use Wuro\ProductCategories\ProductCategoryUpdateParams\State;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ProductCategoriesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class ProductCategoriesRawService implements ProductCategoriesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Crée une nouvelle catégorie pour organiser les produits.
     *
     * **Champs requis:**
     * - `name` : Nom de la catégorie
     *
     * **Événement déclenché:** CREATE_PRODUCT_CATEGORY
     *
     * @param array{name: string, company?: string}|ProductCategoryCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductCategory>
     *
     * @throws APIException
     */
    public function create(
        array|ProductCategoryCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProductCategoryCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'product-category',
            body: (object) $parsed,
            options: $options,
            convert: ProductCategory::class,
        );
    }

    /**
     * @api
     *
     * Récupère les détails d'une catégorie de produit spécifique.
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductCategory>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['product-category/%1$s', $uid],
            options: $requestOptions,
            convert: ProductCategory::class,
        );
    }

    /**
     * @api
     *
     * Met à jour une catégorie de produit existante.
     *
     * **Modifications possibles:**
     * - Renommer la catégorie
     * - Activer/désactiver la catégorie
     *
     * **États:**
     * - `active` : Catégorie visible et utilisable
     * - `inactive` : Catégorie masquée
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param array{
     *   name?: string, state?: State|value-of<State>
     * }|ProductCategoryUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ProductCategoryUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProductCategoryUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['product-category/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Récupère la liste de toutes les catégories de produits de l'entreprise.
     *
     * **Utilisation:**
     * - Organisation du catalogue produits
     * - Filtrage des produits par catégorie
     * - Rapports et statistiques par catégorie
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductCategoryListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'product-categories',
            options: $requestOptions,
            convert: ProductCategoryListResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime une catégorie de produit.
     *
     * **Attention:**
     * - Les produits associés à cette catégorie ne seront plus catégorisés
     * - Cette opération est irréversible
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['product-category/%1$s', $uid],
            options: $requestOptions,
            convert: null,
        );
    }
}
