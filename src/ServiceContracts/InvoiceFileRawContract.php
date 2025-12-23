<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\InvoiceFile\InvoiceFileAnalyzeParams;
use Wuro\InvoiceFile\InvoiceFileAnalyzeResponse;
use Wuro\RequestOptions;

interface InvoiceFileRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|InvoiceFileAnalyzeParams $params
     *
     * @return BaseResponse<InvoiceFileAnalyzeResponse>
     *
     * @throws APIException
     */
    public function analyze(
        array|InvoiceFileAnalyzeParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
