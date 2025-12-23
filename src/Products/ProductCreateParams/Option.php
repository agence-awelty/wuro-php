<?php

declare(strict_types=1);

namespace Wuro\Products\ProductCreateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type OptionShape = array{
 *   name?: string|null, values?: list<string>|null
 * }
 */
final class Option implements BaseModel
{
    /** @use SdkModel<OptionShape> */
    use SdkModel;

    #[Optional]
    public ?string $name;

    /** @var list<string>|null $values */
    #[Optional(list: 'string')]
    public ?array $values;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $values
     */
    public static function with(?string $name = null, ?array $values = null): self
    {
        $self = new self;

        null !== $name && $self['name'] = $name;
        null !== $values && $self['values'] = $values;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<string> $values
     */
    public function withValues(array $values): self
    {
        $self = clone $this;
        $self['values'] = $values;

        return $self;
    }
}
