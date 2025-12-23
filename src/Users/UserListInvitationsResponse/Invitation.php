<?php

declare(strict_types=1);

namespace Wuro\Users\UserListInvitationsResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Users\UserListInvitationsResponse\Invitation\State;

/**
 * @phpstan-type InvitationShape = array{
 *   _id?: string|null,
 *   company?: mixed,
 *   createdAt?: \DateTimeInterface|null,
 *   state?: null|State|value-of<State>,
 * }
 */
final class Invitation implements BaseModel
{
    /** @use SdkModel<InvitationShape> */
    use SdkModel;

    #[Optional]
    public ?string $_id;

    /**
     * Entreprise qui a envoyé l'invitation.
     */
    #[Optional]
    public mixed $company;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /** @var value-of<State>|null $state */
    #[Optional(enum: State::class)]
    public ?string $state;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param State|value-of<State>|null $state
     */
    public static function with(
        ?string $_id = null,
        mixed $company = null,
        ?\DateTimeInterface $createdAt = null,
        State|string|null $state = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $company && $self['company'] = $company;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * Entreprise qui a envoyé l'invitation.
     */
    public function withCompany(mixed $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
