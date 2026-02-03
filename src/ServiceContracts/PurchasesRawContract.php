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

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PurchasesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PurchaseCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param array<string,mixed>|PurchaseRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|PurchaseRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param array<string,mixed>|PurchaseUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PurchaseUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PurchaseListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseDeleteResponse>
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
     * @param string $uid Identifiant unique de l'achat d'origine
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseNewCreditResponse>
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        RequestOptions|array|null $requestOptions = null
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
    public function getStats(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
