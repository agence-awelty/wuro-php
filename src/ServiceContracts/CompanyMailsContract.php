<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\CompanyMails\CompanyMailListResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface CompanyMailsContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): CompanyMailListResponse;
}
