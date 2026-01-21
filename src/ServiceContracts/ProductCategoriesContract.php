<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\ProductCategories\ProductCategory;
use Wuro\ProductCategories\ProductCategoryListResponse;
use Wuro\ProductCategories\ProductCategoryUpdateParams\State;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ProductCategoriesContract
{
    /**
     * @api
     *
     * @param string $name Nom de la catégorie
     * @param string $company ID de l'entreprise (optionnel, défaut = entreprise courante)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $company = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProductCategory;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): ProductCategory;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param string $name Nouveau nom de la catégorie
     * @param State|value-of<State> $state État de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $name = null,
        State|string|null $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): ProductCategoryListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
