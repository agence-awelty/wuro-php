<?php

declare(strict_types=1);

namespace Wuro\Users\UserListInvitationsResponse\Invitation;

enum State: string
{
    case PENDING = 'pending';

    case ACCEPTED = 'accepted';

    case REFUSED = 'refused';

    case EXPIRED = 'expired';
}
