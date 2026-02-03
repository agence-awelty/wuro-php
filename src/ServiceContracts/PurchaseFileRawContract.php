<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\PurchaseFile\PurchaseFileAnalyzeParams;
use Wuro\PurchaseFile\PurchaseFileAnalyzeResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PurchaseFileRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PurchaseFileAnalyzeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseFileAnalyzeResponse>
     *
     * @throws APIException
     */
    public function analyze(
        array|PurchaseFileAnalyzeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
