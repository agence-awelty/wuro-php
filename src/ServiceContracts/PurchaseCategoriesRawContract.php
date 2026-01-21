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

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PurchaseCategoriesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseCategoryCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseCategoryNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PurchaseCategoryCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseCategoryGetResponse>
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
     * @param array<string,mixed>|PurchaseCategoryUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PurchaseCategoryUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseCategoryListResponse>
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
