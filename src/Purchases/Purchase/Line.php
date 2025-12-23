<?php

declare(strict_types=1);

namespace Wuro\Purchases\Purchase;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type LineShape = array{
 *   title?: string|null,
 *   totalHt?: float|null,
 *   totalTtc?: float|null,
 *   totalTva?: float|null,
 *   tva?: string|null,
 *   tvaRate?: float|null,
 *   type?: string|null,
 * }
 */
final class Line implements BaseModel
{
    /** @use SdkModel<LineShape> */
    use SdkModel;

    #[Optional]
    public ?string $title;

    #[Optional]
    public ?float $totalHt;

    #[Optional]
    public ?float $totalTtc;

    #[Optional]
    public ?float $totalTva;

    #[Optional]
    public ?string $tva;

    #[Optional]
    public ?float $tvaRate;

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
        ?string $title = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        ?string $tva = null,
        ?float $tvaRate = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $title && $self['title'] = $title;
        null !== $totalHt && $self['totalHt'] = $totalHt;
        null !== $totalTtc && $self['totalTtc'] = $totalTtc;
        null !== $totalTva && $self['totalTva'] = $totalTva;
        null !== $tva && $self['tva'] = $tva;
        null !== $tvaRate && $self['tvaRate'] = $tvaRate;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withTotalHt(float $totalHt): self
    {
        $self = clone $this;
        $self['totalHt'] = $totalHt;

        return $self;
    }

    public function withTotalTtc(float $totalTtc): self
    {
        $self = clone $this;
        $self['totalTtc'] = $totalTtc;

        return $self;
    }

    public function withTotalTva(float $totalTva): self
    {
        $self = clone $this;
        $self['totalTva'] = $totalTva;

        return $self;
    }

    public function withTva(string $tva): self
    {
        $self = clone $this;
        $self['tva'] = $tva;

        return $self;
    }

    public function withTvaRate(float $tvaRate): self
    {
        $self = clone $this;
        $self['tvaRate'] = $tvaRate;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
