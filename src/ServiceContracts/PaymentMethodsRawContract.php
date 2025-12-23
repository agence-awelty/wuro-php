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

interface PaymentMethodsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PaymentMethodCreateParams $params
     *
     * @return BaseResponse<PaymentMethodNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PaymentMethodCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     *
     * @return BaseResponse<PaymentMethodGetResponse>
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
     * @param string $uid Identifiant unique du moyen de paiement
     * @param array<string,mixed>|PaymentMethodUpdateParams $params
     *
     * @return BaseResponse<PaymentMethodUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PaymentMethodUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PaymentMethodListParams $params
     *
     * @return BaseResponse<PaymentMethodListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PaymentMethodListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     *
     * @return BaseResponse<PaymentMethodDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
