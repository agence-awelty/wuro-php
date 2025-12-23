<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Absences\AbsenceCreateParams;
use Wuro\Absences\AbsenceDeleteResponse;
use Wuro\Absences\AbsenceGetResponse;
use Wuro\Absences\AbsenceListParams;
use Wuro\Absences\AbsenceListResponse;
use Wuro\Absences\AbsenceNewResponse;
use Wuro\Absences\AbsenceRetrieveParams;
use Wuro\Absences\AbsenceUpdateParams;
use Wuro\Absences\AbsenceUpdateResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface AbsencesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceCreateParams $params
     *
     * @return BaseResponse<AbsenceNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AbsenceCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param array<string,mixed>|AbsenceRetrieveParams $params
     *
     * @return BaseResponse<AbsenceGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|AbsenceRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param array<string,mixed>|AbsenceUpdateParams $params
     *
     * @return BaseResponse<AbsenceUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|AbsenceUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceListParams $params
     *
     * @return BaseResponse<AbsenceListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|AbsenceListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     *
     * @return BaseResponse<AbsenceDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
