<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Purchases\PurchaseCreateParams;
use Wuro\Purchases\PurchaseDeleteResponse;
use Wuro\Purchases\PurchaseGetResponse;
use Wuro\Purchases\PurchaseListParams;
use Wuro\Purchases\PurchaseListResponse;
use Wuro\Purchases\PurchaseNewCreditResponse;
use Wuro\Purchases\PurchaseNewResponse;
use Wuro\Purchases\PurchaseRetrieveParams;
use Wuro\Purchases\PurchaseUpdateParams;
use Wuro\Purchases\PurchaseUpdateResponse;
use Wuro\RequestOptions;

interface PurchasesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseCreateParams $params
     *
     * @return BaseResponse<PurchaseNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PurchaseCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param array<string,mixed>|PurchaseRetrieveParams $params
     *
     * @return BaseResponse<PurchaseGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|PurchaseRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param array<string,mixed>|PurchaseUpdateParams $params
     *
     * @return BaseResponse<PurchaseUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PurchaseUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseListParams $params
     *
     * @return BaseResponse<PurchaseListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PurchaseListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     *
     * @return BaseResponse<PurchaseDeleteResponse>
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
     * @param string $uid Identifiant unique de l'achat d'origine
     *
     * @return BaseResponse<PurchaseNewCreditResponse>
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function getStats(
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
