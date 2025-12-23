<?php

declare(strict_types=1);

namespace Wuro\Users\User;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type PhoneShape = array{number?: string|null}
 */
final class Phone implements BaseModel
{
    /** @use SdkModel<PhoneShape> */
    use SdkModel;

    /**
     * User's phone number.
     */
    #[Optional]
    public ?string $number;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $number = null): self
    {
        $self = new self;

        null !== $number && $self['number'] = $number;

        return $self;
    }

    /**
     * User's phone number.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }
}
