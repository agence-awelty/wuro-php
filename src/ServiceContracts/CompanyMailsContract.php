<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\CompanyMails\CompanyMailListResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface CompanyMailsContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function list(
        ?RequestOptions $requestOptions = null
    ): CompanyMailListResponse;
}
