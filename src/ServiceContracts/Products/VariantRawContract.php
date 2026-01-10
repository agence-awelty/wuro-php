<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Products;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Products\Variant\VariantCreateParams;
use Wuro\Products\Variant\VariantDeleteParams;
use Wuro\Products\Variant\VariantRetrieveParams;
use Wuro\Products\Variant\VariantUpdateParams;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface VariantRawContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit parent
     * @param array<string,mixed>|VariantCreateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la variante
     * @param array<string,mixed>|VariantRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Path param: Identifiant unique de la variante
     * @param array<string,mixed>|VariantUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la variante
     * @param array<string,mixed>|VariantDeleteParams $params
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
    ): BaseResponse;
}
