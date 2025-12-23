<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\PurchaseCategories\PurchaseCategoryCreateParams;
use Wuro\PurchaseCategories\PurchaseCategoryGetResponse;
use Wuro\PurchaseCategories\PurchaseCategoryListResponse;
use Wuro\PurchaseCategories\PurchaseCategoryNewResponse;
use Wuro\PurchaseCategories\PurchaseCategoryUpdateParams;
use Wuro\RequestOptions;

interface PurchaseCategoriesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseCategoryCreateParams $params
     *
     * @return BaseResponse<PurchaseCategoryNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PurchaseCategoryCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     *
     * @return BaseResponse<PurchaseCategoryGetResponse>
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
     * @param array<string,mixed>|PurchaseCategoryUpdateParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PurchaseCategoryUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<PurchaseCategoryListResponse>
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
