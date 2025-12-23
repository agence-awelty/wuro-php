<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type LineShape = array{
 *   description?: string|null,
 *   quantity?: float|null,
 *   reference?: string|null,
 *   title?: string|null,
 *   weight?: float|null,
 * }
 */
final class Line implements BaseModel
{
    /** @use SdkModel<LineShape> */
    use SdkModel;

    /**
     * Description détaillée.
     */
    #[Optional]
    public ?string $description;

    /**
     * Quantité.
     */
    #[Optional]
    public ?float $quantity;

    /**
     * Référence produit.
     */
    #[Optional]
    public ?string $reference;

    /**
     * Titre de la ligne.
     */
    #[Optional]
    public ?string $title;

    /**
     * Poids (en kg).
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
     */
    public static function with(
        ?string $description = null,
        ?float $quantity = null,
        ?string $reference = null,
        ?string $title = null,
        ?float $weight = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $quantity && $self['quantity'] = $quantity;
        null !== $reference && $self['reference'] = $reference;
        null !== $title && $self['title'] = $title;
        null !== $weight && $self['weight'] = $weight;

        return $self;
    }

    /**
     * Description détaillée.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Quantité.
     */
    public function withQuantity(float $quantity): self
    {
        $self = clone $this;
        $self['quantity'] = $quantity;

        return $self;
    }

    /**
     * Référence produit.
     */
    public function withReference(string $reference): self
    {
        $self = clone $this;
        $self['reference'] = $reference;

        return $self;
    }

    /**
     * Titre de la ligne.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Poids (en kg).
     */
    public function withWeight(float $weight): self
    {
        $self = clone $this;
        $self['weight'] = $weight;

        return $self;
    }
}
