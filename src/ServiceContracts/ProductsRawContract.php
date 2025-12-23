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

interface ProductsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ProductCreateParams $params
     *
     * @return BaseResponse<ProductNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ProductCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param array<string,mixed>|ProductRetrieveParams $params
     *
     * @return BaseResponse<ProductGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|ProductRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param array<string,mixed>|ProductUpdateParams $params
     *
     * @return BaseResponse<ProductUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ProductUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProductListParams $params
     *
     * @return BaseResponse<ProductListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ProductListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     *
     * @return BaseResponse<ProductDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProductImportFromCsvParams $params
     *
     * @return BaseResponse<ProductImportFromCsvResponse>
     *
     * @throws APIException
     */
    public function importFromCsv(
        array|ProductImportFromCsvParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit parent
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function listVariants(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
