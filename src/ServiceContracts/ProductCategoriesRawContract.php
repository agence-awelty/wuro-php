<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\ProductCategories\ProductCategory;
use Wuro\ProductCategories\ProductCategoryCreateParams;
use Wuro\ProductCategories\ProductCategoryListResponse;
use Wuro\ProductCategories\ProductCategoryUpdateParams;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ProductCategoriesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ProductCategoryCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductCategory>
     *
     * @throws APIException
     */
    public function create(
        array|ProductCategoryCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param array<string,mixed>|ProductCategoryUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductCategoryListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
