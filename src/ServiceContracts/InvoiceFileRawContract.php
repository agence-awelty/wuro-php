<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\InvoiceFile\InvoiceFileAnalyzeParams;
use Wuro\InvoiceFile\InvoiceFileAnalyzeResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface InvoiceFileRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceFileAnalyzeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceFileAnalyzeResponse>
     *
     * @throws APIException
     */
    public function analyze(
        array|InvoiceFileAnalyzeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
