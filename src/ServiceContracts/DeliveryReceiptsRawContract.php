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

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface DeliveryReceiptsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|DeliveryReceiptCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeliveryReceiptNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|DeliveryReceiptCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param array<string,mixed>|DeliveryReceiptRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeliveryReceiptGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|DeliveryReceiptRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param array<string,mixed>|DeliveryReceiptUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeliveryReceiptUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|DeliveryReceiptUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DeliveryReceiptListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeliveryReceiptListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|DeliveryReceiptListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeliveryReceiptDeleteResponse>
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
     * @param string $uid Identifiant unique du bon de livraison source
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeliveryReceiptNewInvoiceResponse>
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeliveryReceiptGenerateHTMLResponse>
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param array<string,mixed>|DeliveryReceiptGeneratePdfParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        array|DeliveryReceiptGeneratePdfParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
