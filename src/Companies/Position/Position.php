<?php

declare(strict_types=1);

namespace Wuro\Companies\Position;

use Wuro\Companies\Position\Position\Right;
use Wuro\Companies\Position\Position\State;
use Wuro\Companies\Position\Position\Team;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type RightShape from \Wuro\Companies\Position\Position\Right
 * @phpstan-import-type TeamShape from \Wuro\Companies\Position\Position\Team
 *
 * @phpstan-type PositionShape = array{
 *   _id?: string|null,
 *   avatar?: string|null,
 *   company?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   entryDate?: \DateTimeInterface|null,
 *   firstName?: string|null,
 *   lastName?: string|null,
 *   releaseDate?: \DateTimeInterface|null,
 *   rights?: list<Right|RightShape>|null,
 *   state?: null|State|value-of<State>,
 *   teams?: list<Team|TeamShape>|null,
 *   type?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   user?: string|null,
 *   userEmail?: string|null,
 * }
 */
final class Position implements BaseModel
{
    /** @use SdkModel<PositionShape> */
    use SdkModel;

    /**
     * Unique identifier for the position.
     */
    #[Optional]
    public ?string $_id;

    /**
     * URL to avatar.
     */
    #[Optional]
    public ?string $avatar;

    /**
     * ID of the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Date when position was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Date of entry.
     */
    #[Optional('entry_date')]
    public ?\DateTimeInterface $entryDate;

    /**
     * First name.
     */
    #[Optional('first_name')]
    public ?string $firstName;

    /**
     * Last name.
     */
    #[Optional('last_name')]
    public ?string $lastName;

    /**
     * Date of release.
     */
    #[Optional('release_date')]
    public ?\DateTimeInterface $releaseDate;

    /**
     * List of rights.
     *
     * @var list<Right>|null $rights
     */
    #[Optional(list: Right::class)]
    public ?array $rights;

    /**
     * State of the position.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * List of teams.
     *
     * @var list<Team>|null $teams
     */
    #[Optional(list: Team::class)]
    public ?array $teams;

    /**
     * Type of the position.
     */
    #[Optional]
    public ?string $type;

    /**
     * Date when position was last updated.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * ID of the user.
     */
    #[Optional]
    public ?string $user;

    /**
     * Email of the user.
     */
    #[Optional]
    public ?string $userEmail;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Right|RightShape>|null $rights
     * @param State|value-of<State>|null $state
     * @param list<Team|TeamShape>|null $teams
     */
    public static function with(
        ?string $_id = null,
        ?string $avatar = null,
        ?string $company = null,
        ?\DateTimeInterface $createdAt = null,
        ?\DateTimeInterface $entryDate = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?\DateTimeInterface $releaseDate = null,
        ?array $rights = null,
        State|string|null $state = null,
        ?array $teams = null,
        ?string $type = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $user = null,
        ?string $userEmail = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $avatar && $self['avatar'] = $avatar;
        null !== $company && $self['company'] = $company;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $entryDate && $self['entryDate'] = $entryDate;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $lastName && $self['lastName'] = $lastName;
        null !== $releaseDate && $self['releaseDate'] = $releaseDate;
        null !== $rights && $self['rights'] = $rights;
        null !== $state && $self['state'] = $state;
        null !== $teams && $self['teams'] = $teams;
        null !== $type && $self['type'] = $type;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $user && $self['user'] = $user;
        null !== $userEmail && $self['userEmail'] = $userEmail;

        return $self;
    }

    /**
     * Unique identifier for the position.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * URL to avatar.
     */
    public function withAvatar(string $avatar): self
    {
        $self = clone $this;
        $self['avatar'] = $avatar;

        return $self;
    }

    /**
     * ID of the company.
     */
    public function withCompany(string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    /**
     * Date when position was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Date of entry.
     */
    public function withEntryDate(\DateTimeInterface $entryDate): self
    {
        $self = clone $this;
        $self['entryDate'] = $entryDate;

        return $self;
    }

    /**
     * First name.
     */
    public function withFirstName(string $firstName): self
    {
        $self = clone $this;
        $self['firstName'] = $firstName;

        return $self;
    }

    /**
     * Last name.
     */
    public function withLastName(string $lastName): self
    {
        $self = clone $this;
        $self['lastName'] = $lastName;

        return $self;
    }

    /**
     * Date of release.
     */
    public function withReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $self = clone $this;
        $self['releaseDate'] = $releaseDate;

        return $self;
    }

    /**
     * List of rights.
     *
     * @param list<Right|RightShape> $rights
     */
    public function withRights(array $rights): self
    {
        $self = clone $this;
        $self['rights'] = $rights;

        return $self;
    }

    /**
     * State of the position.
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * List of teams.
     *
     * @param list<Team|TeamShape> $teams
     */
    public function withTeams(array $teams): self
    {
        $self = clone $this;
        $self['teams'] = $teams;

        return $self;
    }

    /**
     * Type of the position.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Date when position was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * ID of the user.
     */
    public function withUser(string $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }

    /**
     * Email of the user.
     */
    public function withUserEmail(string $userEmail): self
    {
        $self = clone $this;
        $self['userEmail'] = $userEmail;

        return $self;
    }
}
