<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\CompanyMails\CompanyMailListResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface CompanyMailsRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CompanyMailListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
