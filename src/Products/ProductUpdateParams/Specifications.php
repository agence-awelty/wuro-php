<?php

declare(strict_types=1);

namespace Wuro\Products\ProductUpdateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type SpecificationsShape = array{
 *   depth?: float|null,
 *   height?: float|null,
 *   weight?: float|null,
 *   width?: float|null,
 * }
 */
final class Specifications implements BaseModel
{
    /** @use SdkModel<SpecificationsShape> */
    use SdkModel;

    #[Optional]
    public ?float $depth;

    #[Optional]
    public ?float $height;

    #[Optional]
    public ?float $weight;

    #[Optional]
    public ?float $width;

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
        ?float $depth = null,
        ?float $height = null,
        ?float $weight = null,
        ?float $width = null,
    ): self {
        $self = new self;

        null !== $depth && $self['depth'] = $depth;
        null !== $height && $self['height'] = $height;
        null !== $weight && $self['weight'] = $weight;
        null !== $width && $self['width'] = $width;

        return $self;
    }

    public function withDepth(float $depth): self
    {
        $self = clone $this;
        $self['depth'] = $depth;

        return $self;
    }

    public function withHeight(float $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }

    public function withWeight(float $weight): self
    {
        $self = clone $this;
        $self['weight'] = $weight;

        return $self;
    }

    public function withWidth(float $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }
}
