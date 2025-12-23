<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Companies\CompanyConfirmDomainResponse;
use Wuro\Companies\CompanyCreateParams;
use Wuro\Companies\CompanyGetByIDResponse;
use Wuro\Companies\CompanyGetCgvResponse;
use Wuro\Companies\CompanyGetExtraInfosResponse;
use Wuro\Companies\CompanyGetResponse;
use Wuro\Companies\CompanyListPositionsResponse;
use Wuro\Companies\CompanyNewResponse;
use Wuro\Companies\CompanyUpdateResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface CompaniesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CompanyCreateParams $params
     *
     * @return BaseResponse<CompanyNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CompanyCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<CompanyGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<CompanyUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
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
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyConfirmDomainResponse>
     *
     * @throws APIException
     */
    public function confirmDomain(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyListPositionsResponse>
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de l'entreprise
     *
     * @return BaseResponse<CompanyGetByIDResponse>
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyGetCgvResponse>
     *
     * @throws APIException
     */
    public function retrieveCgv(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyGetExtraInfosResponse>
     *
     * @throws APIException
     */
    public function retrieveExtraInfos(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
