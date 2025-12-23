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

interface ProductCategoriesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ProductCategoryCreateParams $params
     *
     * @return BaseResponse<ProductCategory>
     *
     * @throws APIException
     */
    public function create(
        array|ProductCategoryCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     *
     * @return BaseResponse<ProductCategory>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param array<string,mixed>|ProductCategoryUpdateParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ProductCategoryUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<ProductCategoryListResponse>
     *
     * @throws APIException
     */
    public function list(?RequestOptions $requestOptions = null): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
