<?php

declare(strict_types=1);

namespace Wuro\Users;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Users\UserListNotificationsResponse\Notification;

/**
 * @phpstan-import-type NotificationShape from \Wuro\Users\UserListNotificationsResponse\Notification
 *
 * @phpstan-type UserListNotificationsResponseShape = array{
 *   notifications?: list<Notification|NotificationShape>|null,
 *   unreadCount?: int|null,
 * }
 */
final class UserListNotificationsResponse implements BaseModel
{
    /** @use SdkModel<UserListNotificationsResponseShape> */
    use SdkModel;

    /** @var list<Notification>|null $notifications */
    #[Optional(list: Notification::class)]
    public ?array $notifications;

    /**
     * Nombre de notifications non lues.
     */
    #[Optional]
    public ?int $unreadCount;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Notification|NotificationShape>|null $notifications
     */
    public static function with(
        ?array $notifications = null,
        ?int $unreadCount = null
    ): self {
        $self = new self;

        null !== $notifications && $self['notifications'] = $notifications;
        null !== $unreadCount && $self['unreadCount'] = $unreadCount;

        return $self;
    }

    /**
     * @param list<Notification|NotificationShape> $notifications
     */
    public function withNotifications(array $notifications): self
    {
        $self = clone $this;
        $self['notifications'] = $notifications;

        return $self;
    }

    /**
     * Nombre de notifications non lues.
     */
    public function withUnreadCount(int $unreadCount): self
    {
        $self = clone $this;
        $self['unreadCount'] = $unreadCount;

        return $self;
    }
}
