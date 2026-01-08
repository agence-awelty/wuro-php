<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Auth\AuthLoginResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface AuthContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function login(
        string $apiKey,
        string $privateKey,
        RequestOptions|array|null $requestOptions = null,
    ): AuthLoginResponse;
}
