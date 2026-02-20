<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Clients\ClientCreateParams;
use Wuro\Clients\ClientDeleteResponse;
use Wuro\Clients\ClientGetResponse;
use Wuro\Clients\ClientImportFromCsvParams;
use Wuro\Clients\ClientImportFromCsvResponse;
use Wuro\Clients\ClientListParams;
use Wuro\Clients\ClientListResponse;
use Wuro\Clients\ClientMergeParams;
use Wuro\Clients\ClientMergeResponse;
use Wuro\Clients\ClientNewResponse;
use Wuro\Clients\ClientRetrieveParams;
use Wuro\Clients\ClientUpdateParams;
use Wuro\Clients\ClientUpdateResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ClientsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ClientCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ClientCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param array<string,mixed>|ClientRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|ClientRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param array<string,mixed>|ClientUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ClientUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ClientListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ClientListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientDeleteResponse>
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
     * @param array<string,mixed>|ClientImportFromCsvParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientImportFromCsvResponse>
     *
     * @throws APIException
     */
    public function importFromCsv(
        array|ClientImportFromCsvParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ClientMergeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ClientMergeResponse>
     *
     * @throws APIException
     */
    public function merge(
        array|ClientMergeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
