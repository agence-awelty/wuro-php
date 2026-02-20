<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Auth\AuthLoginParams;
use Wuro\Auth\AuthLoginResponse;
use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\AuthRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class AuthRawService implements AuthRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * @param array{apiKey: string, privateKey: string}|AuthLoginParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AuthLoginResponse>
     *
     * @throws APIException
     */
    public function login(
        array|AuthLoginParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AuthLoginParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'auth',
            body: (object) $parsed,
            options: $options,
            convert: AuthLoginResponse::class,
        );
    }
}
