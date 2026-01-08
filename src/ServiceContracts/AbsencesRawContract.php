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

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface AbsencesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AbsenceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param array<string,mixed>|AbsenceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|AbsenceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param array<string,mixed>|AbsenceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|AbsenceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AbsenceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|AbsenceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
