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

interface ClientsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ClientCreateParams $params
     *
     * @return BaseResponse<ClientNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ClientCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param array<string,mixed>|ClientRetrieveParams $params
     *
     * @return BaseResponse<ClientGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|ClientRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     * @param array<string,mixed>|ClientUpdateParams $params
     *
     * @return BaseResponse<ClientUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ClientUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ClientListParams $params
     *
     * @return BaseResponse<ClientListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ClientListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du client
     *
     * @return BaseResponse<ClientDeleteResponse>
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
     * @param array<string,mixed>|ClientImportFromCsvParams $params
     *
     * @return BaseResponse<ClientImportFromCsvResponse>
     *
     * @throws APIException
     */
    public function importFromCsv(
        array|ClientImportFromCsvParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ClientMergeParams $params
     *
     * @return BaseResponse<ClientMergeResponse>
     *
     * @throws APIException
     */
    public function merge(
        array|ClientMergeParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
