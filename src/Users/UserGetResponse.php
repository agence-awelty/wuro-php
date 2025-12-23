<?php

declare(strict_types=1);

namespace Wuro\Users;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type UserShape from \Wuro\Users\User
 *
 * @phpstan-type UserGetResponseShape = array{user?: null|User|UserShape}
 */
final class UserGetResponse implements BaseModel
{
    /** @use SdkModel<UserGetResponseShape> */
    use SdkModel;

    #[Optional]
    public ?User $user;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param User|UserShape|null $user
     */
    public static function with(User|array|null $user = null): self
    {
        $self = new self;

        null !== $user && $self['user'] = $user;

        return $self;
    }

    /**
     * @param User|UserShape $user
     */
    public function withUser(User|array $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }
}
