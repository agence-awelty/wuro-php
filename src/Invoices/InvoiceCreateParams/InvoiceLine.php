<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceCreateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceCreateParams\InvoiceLine\Type;

/**
 * @phpstan-type InvoiceLineShape = array{
 *   description?: string|null,
 *   discount?: float|null,
 *   priceHt?: float|null,
 *   product?: string|null,
 *   quantity?: float|null,
 *   reference?: string|null,
 *   title?: string|null,
 *   tvaRate?: float|null,
 *   type?: null|\Wuro\Invoices\InvoiceCreateParams\InvoiceLine\Type|value-of<\Wuro\Invoices\InvoiceCreateParams\InvoiceLine\Type>,
 *   unit?: string|null,
 * }
 */
final class InvoiceLine implements BaseModel
{
    /** @use SdkModel<InvoiceLineShape> */
    use SdkModel;

    /**
     * Description détaillée.
     */
    #[Optional]
    public ?string $description;

    /**
     * Remise en pourcentage.
     */
    #[Optional]
    public ?float $discount;

    /**
     * Prix unitaire HT.
     */
    #[Optional('price_ht')]
    public ?float $priceHt;

    /**
     * ID du produit (optionnel).
     */
    #[Optional]
    public ?string $product;

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
     * Taux de TVA (ex. 20 pour 20%).
     */
    #[Optional('tva_rate')]
    public ?float $tvaRate;

    /**
     * Type de ligne.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * Unité (pièce, heure, etc.).
     */
    #[Optional]
    public ?string $unit;

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
        ?float $discount = null,
        ?float $priceHt = null,
        ?string $product = null,
        ?float $quantity = null,
        ?string $reference = null,
        ?string $title = null,
        ?float $tvaRate = null,
        Type|string|null $type = null,
        ?string $unit = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $discount && $self['discount'] = $discount;
        null !== $priceHt && $self['priceHt'] = $priceHt;
        null !== $product && $self['product'] = $product;
        null !== $quantity && $self['quantity'] = $quantity;
        null !== $reference && $self['reference'] = $reference;
        null !== $title && $self['title'] = $title;
        null !== $tvaRate && $self['tvaRate'] = $tvaRate;
        null !== $type && $self['type'] = $type;
        null !== $unit && $self['unit'] = $unit;

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
     * Remise en pourcentage.
     */
    public function withDiscount(float $discount): self
    {
        $self = clone $this;
        $self['discount'] = $discount;

        return $self;
    }

    /**
     * Prix unitaire HT.
     */
    public function withPriceHt(float $priceHt): self
    {
        $self = clone $this;
        $self['priceHt'] = $priceHt;

        return $self;
    }

    /**
     * ID du produit (optionnel).
     */
    public function withProduct(string $product): self
    {
        $self = clone $this;
        $self['product'] = $product;

        return $self;
    }

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
     * Taux de TVA (ex. 20 pour 20%).
     */
    public function withTvaRate(float $tvaRate): self
    {
        $self = clone $this;
        $self['tvaRate'] = $tvaRate;

        return $self;
    }

    /**
     * Type de ligne.
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
     * Unité (pièce, heure, etc.).
     */
    public function withUnit(string $unit): self
    {
        $self = clone $this;
        $self['unit'] = $unit;

        return $self;
    }
}
