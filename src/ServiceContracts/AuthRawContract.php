<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Auth\AuthLoginParams;
use Wuro\Auth\AuthLoginResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface AuthRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AuthLoginParams $params
     *
     * @return BaseResponse<AuthLoginResponse>
     *
     * @throws APIException
     */
    public function login(
        array|AuthLoginParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
