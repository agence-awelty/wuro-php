<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Quotes\QuoteCreateAdvanceInvoiceParams;
use Wuro\Quotes\QuoteCreatePackageParams;
use Wuro\Quotes\QuoteCreateParams;
use Wuro\Quotes\QuoteDeleteResponse;
use Wuro\Quotes\QuoteGetLogsParams;
use Wuro\Quotes\QuoteGetLogsResponse;
use Wuro\Quotes\QuoteGetResponse;
use Wuro\Quotes\QuoteGetStatsParams;
use Wuro\Quotes\QuoteGetStatsResponse;
use Wuro\Quotes\QuoteListParams;
use Wuro\Quotes\QuoteListResponse;
use Wuro\Quotes\QuoteNewAdvanceInvoiceResponse;
use Wuro\Quotes\QuoteNewInvoiceFromQuoteResponse;
use Wuro\Quotes\QuoteNewInvoiceResponse;
use Wuro\Quotes\QuoteNewPackageResponse;
use Wuro\Quotes\QuoteNewProformaInvoiceResponse;
use Wuro\Quotes\QuoteNewPurchaseOrderResponse;
use Wuro\Quotes\QuoteNewResponse;
use Wuro\Quotes\QuoteRetrieveParams;
use Wuro\Quotes\QuoteUpdateParams;
use Wuro\Quotes\QuoteUpdateResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface QuotesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|QuoteCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|QuoteCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param array<string,mixed>|QuoteRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|QuoteRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|QuoteUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|QuoteUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|QuoteListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|QuoteListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteDeleteResponse>
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
     * @param string $uid ID du devis
     * @param array<string,mixed>|QuoteCreateAdvanceInvoiceParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteNewAdvanceInvoiceResponse>
     *
     * @throws APIException
     */
    public function createAdvanceInvoice(
        string $uid,
        array|QuoteCreateAdvanceInvoiceParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
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
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteNewInvoiceResponse>
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
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteNewInvoiceFromQuoteResponse>
     *
     * @throws APIException
     */
    public function createInvoiceFromQuote(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|QuoteCreatePackageParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteNewPackageResponse>
     *
     * @throws APIException
     */
    public function createPackage(
        array|QuoteCreatePackageParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteNewProformaInvoiceResponse>
     *
     * @throws APIException
     */
    public function createProformaInvoice(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteNewPurchaseOrderResponse>
     *
     * @throws APIException
     */
    public function createPurchaseOrder(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
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
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function generatePdfChromium(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|QuoteGetLogsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteGetLogsResponse>
     *
     * @throws APIException
     */
    public function getLogs(
        array|QuoteGetLogsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|QuoteGetStatsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<QuoteGetStatsResponse>
     *
     * @throws APIException
     */
    public function getStats(
        array|QuoteGetStatsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
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
}
