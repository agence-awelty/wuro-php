<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptCreateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line\Type;

/**
 * @phpstan-type LineShape = array{
 *   description?: string|null,
 *   order?: int|null,
 *   quantity?: float|null,
 *   reference?: string|null,
 *   title?: string|null,
 *   type?: null|\Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line\Type|value-of<\Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line\Type>,
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
     * Ordre d'affichage de la ligne.
     */
    #[Optional]
    public ?int $order;

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
     * Type de ligne :
     * - **product** : Ligne produit standard
     * - **header** : Ligne de titre/séparation
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(
        enum: Type::class
    )]
    public ?string $type;

    /**
     * Poids unitaire (en kg).
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
        ?int $order = null,
        ?float $quantity = null,
        ?string $reference = null,
        ?string $title = null,
        Type|string|null $type = null,
        ?float $weight = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $order && $self['order'] = $order;
        null !== $quantity && $self['quantity'] = $quantity;
        null !== $reference && $self['reference'] = $reference;
        null !== $title && $self['title'] = $title;
        null !== $type && $self['type'] = $type;
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
     * Ordre d'affichage de la ligne.
     */
    public function withOrder(int $order): self
    {
        $self = clone $this;
        $self['order'] = $order;

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
     * Type de ligne :
     * - **product** : Ligne produit standard
     * - **header** : Ligne de titre/séparation
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
     * Poids unitaire (en kg).
     */
    public function withWeight(float $weight): self
    {
        $self = clone $this;
        $self['weight'] = $weight;

        return $self;
    }
}
