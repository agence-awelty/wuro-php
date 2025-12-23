<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\PurchaseFile\PurchaseFileAnalyzeParams;
use Wuro\PurchaseFile\PurchaseFileAnalyzeResponse;
use Wuro\RequestOptions;

interface PurchaseFileRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseFileAnalyzeParams $params
     *
     * @return BaseResponse<PurchaseFileAnalyzeResponse>
     *
     * @throws APIException
     */
    public function analyze(
        array|PurchaseFileAnalyzeParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
