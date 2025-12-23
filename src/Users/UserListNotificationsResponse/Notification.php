<?php

declare(strict_types=1);

namespace Wuro\Users\UserListNotificationsResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type NotificationShape = array{
 *   _id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   message?: string|null,
 *   read?: bool|null,
 *   type?: string|null,
 * }
 */
final class Notification implements BaseModel
{
    /** @use SdkModel<NotificationShape> */
    use SdkModel;

    #[Optional]
    public ?string $_id;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Message de la notification.
     */
    #[Optional]
    public ?string $message;

    /**
     * Notification lue ou non.
     */
    #[Optional]
    public ?bool $read;

    /**
     * Type de notification.
     */
    #[Optional]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $_id = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $message = null,
        ?bool $read = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $message && $self['message'] = $message;
        null !== $read && $self['read'] = $read;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Message de la notification.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Notification lue ou non.
     */
    public function withRead(bool $read): self
    {
        $self = clone $this;
        $self['read'] = $read;

        return $self;
    }

    /**
     * Type de notification.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
