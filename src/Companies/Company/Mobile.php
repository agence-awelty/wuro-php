<?php

declare(strict_types=1);

namespace Wuro\Companies\Company;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type MobileShape = array{
 *   active?: bool|null, main?: bool|null, number?: string|null, type?: string|null
 * }
 */
final class Mobile implements BaseModel
{
    /** @use SdkModel<MobileShape> */
    use SdkModel;

    /**
     * Whether this mobile number is active.
     */
    #[Optional]
    public ?bool $active;

    /**
     * Whether this is the main mobile number.
     */
    #[Optional]
    public ?bool $main;

    /**
     * Mobile number.
     */
    #[Optional]
    public ?string $number;

    /**
     * Type of mobile number.
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
        ?bool $active = null,
        ?bool $main = null,
        ?string $number = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $active && $self['active'] = $active;
        null !== $main && $self['main'] = $main;
        null !== $number && $self['number'] = $number;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Whether this mobile number is active.
     */
    public function withActive(bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }

    /**
     * Whether this is the main mobile number.
     */
    public function withMain(bool $main): self
    {
        $self = clone $this;
        $self['main'] = $main;

        return $self;
    }

    /**
     * Mobile number.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * Type of mobile number.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
