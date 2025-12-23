<?php

declare(strict_types=1);

namespace Wuro\ProductCategories;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\ProductCategories\ProductCategory\State;

/**
 * @phpstan-type ProductCategoryShape = array{
 *   _id?: string|null,
 *   company?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   name?: string|null,
 *   state?: null|State|value-of<State>,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class ProductCategory implements BaseModel
{
    /** @use SdkModel<ProductCategoryShape> */
    use SdkModel;

    #[Optional]
    public ?string $_id;

    #[Optional]
    public ?string $company;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional]
    public ?string $name;

    /** @var value-of<State>|null $state */
    #[Optional(enum: State::class)]
    public ?string $state;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

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
        ?string $company = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $name = null,
        State|string|null $state = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $company && $self['company'] = $company;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $name && $self['name'] = $name;
        null !== $state && $self['state'] = $state;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    public function withCompany(string $company): self
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

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
