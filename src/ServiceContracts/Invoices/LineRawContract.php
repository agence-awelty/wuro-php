<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Invoices;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Invoices\Line\Invoice;
use Wuro\Invoices\Line\LineAddParams;
use Wuro\Invoices\Line\LineAddResponse;
use Wuro\Invoices\Line\LineDeleteParams;
use Wuro\Invoices\Line\LineUpdateParams;
use Wuro\Invoices\Line\LineUpdateResponse;
use Wuro\RequestOptions;

interface LineRawContract
{
    /**
     * @api
     *
     * @param string $lineUuid Path param: Identifiant unique de la ligne à modifier
     * @param array<string,mixed>|LineUpdateParams $params
     *
     * @return BaseResponse<LineUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $lineUuid,
        array|LineUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $lineUuid Identifiant unique de la ligne à supprimer
     * @param array<string,mixed>|LineDeleteParams $params
     *
     * @return BaseResponse<Invoice>
     *
     * @throws APIException
     */
    public function delete(
        string $lineUuid,
        array|LineDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param array<string,mixed>|LineAddParams $params
     *
     * @return BaseResponse<LineAddResponse>
     *
     * @throws APIException
     */
    public function add(
        string $uid,
        array|LineAddParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
