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

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface CompaniesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CompanyCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CompanyCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
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
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyConfirmDomainResponse>
     *
     * @throws APIException
     */
    public function confirmDomain(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyListPositionsResponse>
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de l'entreprise
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyGetByIDResponse>
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyGetCgvResponse>
     *
     * @throws APIException
     */
    public function retrieveCgv(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyGetExtraInfosResponse>
     *
     * @throws APIException
     */
    public function retrieveExtraInfos(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
