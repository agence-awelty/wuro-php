<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\CompanyMails\CompanyMailListResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface CompanyMailsRawContract
{
    /**
     * @api
     *
     * @return BaseResponse<CompanyMailListResponse>
     *
     * @throws APIException
     */
    public function list(?RequestOptions $requestOptions = null): BaseResponse;
}
