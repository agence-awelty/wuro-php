<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\AbsenceTypes\AbsenceTypeCreateParams;
use Wuro\AbsenceTypes\AbsenceTypeDeleteResponse;
use Wuro\AbsenceTypes\AbsenceTypeGetResponse;
use Wuro\AbsenceTypes\AbsenceTypeListParams;
use Wuro\AbsenceTypes\AbsenceTypeListResponse;
use Wuro\AbsenceTypes\AbsenceTypeNewResponse;
use Wuro\AbsenceTypes\AbsenceTypeUpdateParams;
use Wuro\AbsenceTypes\AbsenceTypeUpdateResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface AbsenceTypesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceTypeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AbsenceTypeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du type d'absence
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeGetResponse>
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
     * @param string $uid Identifiant unique du type d'absence
     * @param array<string,mixed>|AbsenceTypeUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|AbsenceTypeUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceTypeListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|AbsenceTypeListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du type d'absence
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
