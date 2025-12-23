<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams;
use Wuro\DeliveryReceipts\DeliveryReceiptDeleteResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGeneratePdfParams;
use Wuro\DeliveryReceipts\DeliveryReceiptGetResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptListParams;
use Wuro\DeliveryReceipts\DeliveryReceiptListResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewInvoiceResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptRetrieveParams;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateResponse;
use Wuro\RequestOptions;

interface DeliveryReceiptsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|DeliveryReceiptCreateParams $params
     *
     * @return BaseResponse<DeliveryReceiptNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|DeliveryReceiptCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param array<string,mixed>|DeliveryReceiptRetrieveParams $params
     *
     * @return BaseResponse<DeliveryReceiptGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|DeliveryReceiptRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param array<string,mixed>|DeliveryReceiptUpdateParams $params
     *
     * @return BaseResponse<DeliveryReceiptUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|DeliveryReceiptUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DeliveryReceiptListParams $params
     *
     * @return BaseResponse<DeliveryReceiptListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|DeliveryReceiptListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     *
     * @return BaseResponse<DeliveryReceiptDeleteResponse>
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
     * @param string $uid Identifiant unique du bon de livraison source
     *
     * @return BaseResponse<DeliveryReceiptNewInvoiceResponse>
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     *
     * @return BaseResponse<DeliveryReceiptGenerateHTMLResponse>
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param array<string,mixed>|DeliveryReceiptGeneratePdfParams $params
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        array|DeliveryReceiptGeneratePdfParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
