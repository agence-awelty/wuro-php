<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Invoices\InvoiceCreatePackageParams;
use Wuro\Invoices\InvoiceCreateParams;
use Wuro\Invoices\InvoiceGetLogsParams;
use Wuro\Invoices\InvoiceGetLogsResponse;
use Wuro\Invoices\InvoiceGetResponse;
use Wuro\Invoices\InvoiceGetStatsParams;
use Wuro\Invoices\InvoiceGetStatsResponse;
use Wuro\Invoices\InvoiceGetTurnoverParams;
use Wuro\Invoices\InvoiceGetTurnoverResponse;
use Wuro\Invoices\InvoiceListParams;
use Wuro\Invoices\InvoiceListPaymentsParams;
use Wuro\Invoices\InvoiceListPaymentsResponse;
use Wuro\Invoices\InvoiceListResponse;
use Wuro\Invoices\InvoiceListWaitingPaymentsParams;
use Wuro\Invoices\InvoiceListWaitingPaymentsResponse;
use Wuro\Invoices\InvoiceNewCreditResponse;
use Wuro\Invoices\InvoiceNewPackageResponse;
use Wuro\Invoices\InvoiceNewResponse;
use Wuro\Invoices\InvoiceRecordPaymentParams;
use Wuro\Invoices\InvoiceRecordPaymentResponse;
use Wuro\Invoices\InvoiceRetrieveParams;
use Wuro\Invoices\InvoiceSendEmailParams;
use Wuro\Invoices\InvoiceSendEmailResponse;
use Wuro\Invoices\InvoiceUpdateParams;
use Wuro\Invoices\InvoiceUpdateResponse;
use Wuro\RequestOptions;

interface InvoicesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceCreateParams $params
     *
     * @return BaseResponse<InvoiceNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|InvoiceCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param array<string,mixed>|InvoiceRetrieveParams $params
     *
     * @return BaseResponse<InvoiceGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|InvoiceRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceUpdateParams $params
     *
     * @return BaseResponse<InvoiceUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|InvoiceUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceListParams $params
     *
     * @return BaseResponse<InvoiceListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|InvoiceListParams $params,
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
     * @param string $uid ID de la facture d'origine
     *
     * @return BaseResponse<InvoiceNewCreditResponse>
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function createDeliveryReceipt(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceCreatePackageParams $params
     *
     * @return BaseResponse<InvoiceNewPackageResponse>
     *
     * @throws APIException
     */
    public function createPackage(
        array|InvoiceCreatePackageParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceGetLogsParams $params
     *
     * @return BaseResponse<InvoiceGetLogsResponse>
     *
     * @throws APIException
     */
    public function getLogs(
        array|InvoiceGetLogsParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceGetStatsParams $params
     *
     * @return BaseResponse<InvoiceGetStatsResponse>
     *
     * @throws APIException
     */
    public function getStats(
        array|InvoiceGetStatsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceGetTurnoverParams $params
     *
     * @return BaseResponse<InvoiceGetTurnoverResponse>
     *
     * @throws APIException
     */
    public function getTurnover(
        array|InvoiceGetTurnoverParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceListPaymentsParams $params
     *
     * @return BaseResponse<InvoiceListPaymentsResponse>
     *
     * @throws APIException
     */
    public function listPayments(
        array|InvoiceListPaymentsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceListWaitingPaymentsParams $params
     *
     * @return BaseResponse<InvoiceListWaitingPaymentsResponse>
     *
     * @throws APIException
     */
    public function listWaitingPayments(
        array|InvoiceListWaitingPaymentsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param array<string,mixed>|InvoiceRecordPaymentParams $params
     *
     * @return BaseResponse<InvoiceRecordPaymentResponse>
     *
     * @throws APIException
     */
    public function recordPayment(
        string $uid,
        array|InvoiceRecordPaymentParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param array<string,mixed>|InvoiceSendEmailParams $params
     *
     * @return BaseResponse<InvoiceSendEmailResponse>
     *
     * @throws APIException
     */
    public function sendEmail(
        string $uid,
        array|InvoiceSendEmailParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
