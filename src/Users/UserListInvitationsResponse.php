<?php

declare(strict_types=1);

namespace Wuro\Users;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Users\UserListInvitationsResponse\Invitation;

/**
 * @phpstan-import-type InvitationShape from \Wuro\Users\UserListInvitationsResponse\Invitation
 *
 * @phpstan-type UserListInvitationsResponseShape = array{
 *   invitations?: list<Invitation|InvitationShape>|null
 * }
 */
final class UserListInvitationsResponse implements BaseModel
{
    /** @use SdkModel<UserListInvitationsResponseShape> */
    use SdkModel;

    /** @var list<Invitation>|null $invitations */
    #[Optional(list: Invitation::class)]
    public ?array $invitations;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Invitation|InvitationShape>|null $invitations
     */
    public static function with(?array $invitations = null): self
    {
        $self = new self;

        null !== $invitations && $self['invitations'] = $invitations;

        return $self;
    }

    /**
     * @param list<Invitation|InvitationShape> $invitations
     */
    public function withInvitations(array $invitations): self
    {
        $self = clone $this;
        $self['invitations'] = $invitations;

        return $self;
    }
}
