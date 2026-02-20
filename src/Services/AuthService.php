<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Auth\AuthLoginResponse;
use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\AuthContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class AuthService implements AuthContract
{
    /**
     * @api
     */
    public AuthRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AuthRawService($client);
    }

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
    ): AuthLoginResponse {
        $params = Util::removeNulls(
            ['apiKey' => $apiKey, 'privateKey' => $privateKey]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->login(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
