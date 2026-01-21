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

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface InvoicesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|InvoiceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param array<string,mixed>|InvoiceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|InvoiceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|InvoiceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|InvoiceListParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * @param string $uid ID de la facture d'origine
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceNewCreditResponse>
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function createDeliveryReceipt(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceCreatePackageParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceNewPackageResponse>
     *
     * @throws APIException
     */
    public function createPackage(
        array|InvoiceCreatePackageParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceGetLogsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceGetLogsResponse>
     *
     * @throws APIException
     */
    public function getLogs(
        array|InvoiceGetLogsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceGetStatsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceGetStatsResponse>
     *
     * @throws APIException
     */
    public function getStats(
        array|InvoiceGetStatsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceGetTurnoverParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceGetTurnoverResponse>
     *
     * @throws APIException
     */
    public function getTurnover(
        array|InvoiceGetTurnoverParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceListPaymentsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceListPaymentsResponse>
     *
     * @throws APIException
     */
    public function listPayments(
        array|InvoiceListPaymentsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceListWaitingPaymentsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceListWaitingPaymentsResponse>
     *
     * @throws APIException
     */
    public function listWaitingPayments(
        array|InvoiceListWaitingPaymentsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param array<string,mixed>|InvoiceRecordPaymentParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceRecordPaymentResponse>
     *
     * @throws APIException
     */
    public function recordPayment(
        string $uid,
        array|InvoiceRecordPaymentParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param array<string,mixed>|InvoiceSendEmailParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceSendEmailResponse>
     *
     * @throws APIException
     */
    public function sendEmail(
        string $uid,
        array|InvoiceSendEmailParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
