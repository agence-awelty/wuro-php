<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\PaymentMethods\PaymentMethodCreateParams;
use Wuro\PaymentMethods\PaymentMethodDeleteResponse;
use Wuro\PaymentMethods\PaymentMethodGetResponse;
use Wuro\PaymentMethods\PaymentMethodListParams;
use Wuro\PaymentMethods\PaymentMethodListResponse;
use Wuro\PaymentMethods\PaymentMethodNewResponse;
use Wuro\PaymentMethods\PaymentMethodUpdateParams;
use Wuro\PaymentMethods\PaymentMethodUpdateResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PaymentMethodsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PaymentMethodCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaymentMethodNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PaymentMethodCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaymentMethodGetResponse>
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
     * @param string $uid Identifiant unique du moyen de paiement
     * @param array<string,mixed>|PaymentMethodUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaymentMethodUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PaymentMethodUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PaymentMethodListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaymentMethodListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PaymentMethodListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaymentMethodDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
