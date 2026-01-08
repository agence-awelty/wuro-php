<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Auth\AuthLoginParams;
use Wuro\Auth\AuthLoginResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface AuthRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AuthLoginParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AuthLoginResponse>
     *
     * @throws APIException
     */
    public function login(
        array|AuthLoginParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
