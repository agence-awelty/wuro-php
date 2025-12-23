<?php

declare(strict_types=1);

namespace Wuro\ProductUnits;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type ProductUnitListResponseItemShape = array{
 *   label?: string|null, value?: string|null
 * }
 */
final class ProductUnitListResponseItem implements BaseModel
{
    /** @use SdkModel<ProductUnitListResponseItemShape> */
    use SdkModel;

    /**
     * Libellé affiché.
     */
    #[Optional]
    public ?string $label;

    /**
     * Valeur technique de l'unité.
     */
    #[Optional]
    public ?string $value;

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
        ?string $label = null,
        ?string $value = null
    ): self {
        $self = new self;

        null !== $label && $self['label'] = $label;
        null !== $value && $self['value'] = $value;

        return $self;
    }

    /**
     * Libellé affiché.
     */
    public function withLabel(string $label): self
    {
        $self = clone $this;
        $self['label'] = $label;

        return $self;
    }

    /**
     * Valeur technique de l'unité.
     */
    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
