<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\Line\LineAddParams\Type;

/**
 * Ajoute une nouvelle ligne à une facture existante.
 *
 * Les totaux sont automatiquement recalculés après l'ajout.
 *
 * @see Wuro\Services\Invoices\LineService::add()
 *
 * @phpstan-type LineAddParamsShape = array{
 *   _id?: string|null,
 *   description?: string|null,
 *   priceHt?: float|null,
 *   quantity?: float|null,
 *   reference?: string|null,
 *   title?: string|null,
 *   totalHt?: float|null,
 *   totalTtc?: float|null,
 *   tvaRate?: float|null,
 *   type?: null|Type|value-of<Type>,
 *   unit?: string|null,
 * }
 */
final class LineAddParams implements BaseModel
{
    /** @use SdkModel<LineAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Unique identifier for the line.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Description of the line.
     */
    #[Optional]
    public ?string $description;

    /**
     * Price without tax.
     */
    #[Optional('price_ht')]
    public ?float $priceHt;

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
     * Total amount without tax.
     */
    #[Optional('total_ht')]
    public ?float $totalHt;

    /**
     * Total amount with tax.
     */
    #[Optional('total_ttc')]
    public ?float $totalTtc;

    /**
     * VAT rate.
     */
    #[Optional('tva_rate')]
    public ?float $tvaRate;

    /**
     * Type of the line.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * Unit of measurement.
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
        ?string $_id = null,
        ?string $description = null,
        ?float $priceHt = null,
        ?float $quantity = null,
        ?string $reference = null,
        ?string $title = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $tvaRate = null,
        Type|string|null $type = null,
        ?string $unit = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $description && $self['description'] = $description;
        null !== $priceHt && $self['priceHt'] = $priceHt;
        null !== $quantity && $self['quantity'] = $quantity;
        null !== $reference && $self['reference'] = $reference;
        null !== $title && $self['title'] = $title;
        null !== $totalHt && $self['totalHt'] = $totalHt;
        null !== $totalTtc && $self['totalTtc'] = $totalTtc;
        null !== $tvaRate && $self['tvaRate'] = $tvaRate;
        null !== $type && $self['type'] = $type;
        null !== $unit && $self['unit'] = $unit;

        return $self;
    }

    /**
     * Unique identifier for the line.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

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
     * Price without tax.
     */
    public function withPriceHt(float $priceHt): self
    {
        $self = clone $this;
        $self['priceHt'] = $priceHt;

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
     * Total amount without tax.
     */
    public function withTotalHt(float $totalHt): self
    {
        $self = clone $this;
        $self['totalHt'] = $totalHt;

        return $self;
    }

    /**
     * Total amount with tax.
     */
    public function withTotalTtc(float $totalTtc): self
    {
        $self = clone $this;
        $self['totalTtc'] = $totalTtc;

        return $self;
    }

    /**
     * VAT rate.
     */
    public function withTvaRate(float $tvaRate): self
    {
        $self = clone $this;
        $self['tvaRate'] = $tvaRate;

        return $self;
    }

    /**
     * Type of the line.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Unit of measurement.
     */
    public function withUnit(string $unit): self
    {
        $self = clone $this;
        $self['unit'] = $unit;

        return $self;
    }
}
