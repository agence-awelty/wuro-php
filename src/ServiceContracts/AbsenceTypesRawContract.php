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

interface AbsenceTypesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceTypeCreateParams $params
     *
     * @return BaseResponse<AbsenceTypeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AbsenceTypeCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du type d'absence
     *
     * @return BaseResponse<AbsenceTypeGetResponse>
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
     * @param string $uid Identifiant unique du type d'absence
     * @param array<string,mixed>|AbsenceTypeUpdateParams $params
     *
     * @return BaseResponse<AbsenceTypeUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|AbsenceTypeUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceTypeListParams $params
     *
     * @return BaseResponse<AbsenceTypeListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|AbsenceTypeListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du type d'absence
     *
     * @return BaseResponse<AbsenceTypeDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
