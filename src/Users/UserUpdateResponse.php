<?php

declare(strict_types=1);

namespace Wuro\Users;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type UserShape from \Wuro\Users\User
 *
 * @phpstan-type UserUpdateResponseShape = array{updatedUser?: null|User|UserShape}
 */
final class UserUpdateResponse implements BaseModel
{
    /** @use SdkModel<UserUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?User $updatedUser;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param User|UserShape|null $updatedUser
     */
    public static function with(User|array|null $updatedUser = null): self
    {
        $self = new self;

        null !== $updatedUser && $self['updatedUser'] = $updatedUser;

        return $self;
    }

    /**
     * @param User|UserShape $updatedUser
     */
    public function withUpdatedUser(User|array $updatedUser): self
    {
        $self = clone $this;
        $self['updatedUser'] = $updatedUser;

        return $self;
    }
}
