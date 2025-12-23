<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\Receipt;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\DeliveryReceipts\Receipt\Line\Type;

/**
 * @phpstan-type LineShape = array{
 *   description?: string|null,
 *   quantity?: float|null,
 *   reference?: string|null,
 *   title?: string|null,
 *   type?: null|\Wuro\DeliveryReceipts\Receipt\Line\Type|value-of<\Wuro\DeliveryReceipts\Receipt\Line\Type>,
 *   weight?: float|null,
 * }
 */
final class Line implements BaseModel
{
    /** @use SdkModel<LineShape> */
    use SdkModel;

    /**
     * Description of the line.
     */
    #[Optional]
    public ?string $description;

    /**
     * Quantity.
     */
    #[Optional]
    public ?float $quantity;

    /**
     * Reference of the product.
     */
    #[Optional]
    public ?string $reference;

    /**
     * Title of the line.
     */
    #[Optional]
    public ?string $title;

    /**
     * Type of the line.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * Weight of the product.
     */
    #[Optional]
    public ?float $weight;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $description = null,
        ?float $quantity = null,
        ?string $reference = null,
        ?string $title = null,
        Type|string|null $type = null,
        ?float $weight = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $quantity && $self['quantity'] = $quantity;
        null !== $reference && $self['reference'] = $reference;
        null !== $title && $self['title'] = $title;
        null !== $type && $self['type'] = $type;
        null !== $weight && $self['weight'] = $weight;

        return $self;
    }

    /**
     * Description of the line.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Quantity.
     */
    public function withQuantity(float $quantity): self
    {
        $self = clone $this;
        $self['quantity'] = $quantity;

        return $self;
    }

    /**
     * Reference of the product.
     */
    public function withReference(string $reference): self
    {
        $self = clone $this;
        $self['reference'] = $reference;

        return $self;
    }

    /**
     * Title of the line.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Type of the line.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(
        Type|string $type
    ): self {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Weight of the product.
     */
    public function withWeight(float $weight): self
    {
        $self = clone $this;
        $self['weight'] = $weight;

        return $self;
    }
}
