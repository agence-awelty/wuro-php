<?php

declare(strict_types=1);

namespace Wuro\Auth;

use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * @see Wuro\Services\AuthService::login()
 *
 * @phpstan-type AuthLoginParamsShape = array{apiKey: string, privateKey: string}
 */
final class AuthLoginParams implements BaseModel
{
    /** @use SdkModel<AuthLoginParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required('api_key')]
    public string $apiKey;

    #[Required('private_key')]
    public string $privateKey;

    /**
     * `new AuthLoginParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AuthLoginParams::with(apiKey: ..., privateKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AuthLoginParams)->withAPIKey(...)->withPrivateKey(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $apiKey, string $privateKey): self
    {
        $self = new self;

        $self['apiKey'] = $apiKey;
        $self['privateKey'] = $privateKey;

        return $self;
    }

    public function withAPIKey(string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    public function withPrivateKey(string $privateKey): self
    {
        $self = clone $this;
        $self['privateKey'] = $privateKey;

        return $self;
    }
}
