<?php

declare(strict_types=1);

namespace Wuro\Auth;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type AuthLoginResponseShape = array{token?: string|null}
 */
final class AuthLoginResponse implements BaseModel
{
    /** @use SdkModel<AuthLoginResponseShape> */
    use SdkModel;

    #[Optional]
    public ?string $token;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $token = null): self
    {
        $self = new self;

        null !== $token && $self['token'] = $token;

        return $self;
    }

    public function withToken(string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }
}
