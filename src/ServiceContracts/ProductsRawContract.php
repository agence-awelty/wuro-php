<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Products\ProductCreateParams;
use Wuro\Products\ProductDeleteResponse;
use Wuro\Products\ProductGetResponse;
use Wuro\Products\ProductImportFromCsvParams;
use Wuro\Products\ProductImportFromCsvResponse;
use Wuro\Products\ProductListParams;
use Wuro\Products\ProductListResponse;
use Wuro\Products\ProductNewResponse;
use Wuro\Products\ProductRetrieveParams;
use Wuro\Products\ProductUpdateParams;
use Wuro\Products\ProductUpdateResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ProductsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ProductCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ProductCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param array<string,mixed>|ProductRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|ProductRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param array<string,mixed>|ProductUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ProductUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProductListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ProductListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProductImportFromCsvParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductImportFromCsvResponse>
     *
     * @throws APIException
     */
    public function importFromCsv(
        array|ProductImportFromCsvParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit parent
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function listVariants(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
