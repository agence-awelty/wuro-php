<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Auth\AuthLoginResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface AuthContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function login(
        string $apiKey,
        string $privateKey,
        ?RequestOptions $requestOptions = null
    ): AuthLoginResponse;
}
