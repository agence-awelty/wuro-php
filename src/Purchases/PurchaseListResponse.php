<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PurchaseShape from \Wuro\Purchases\Purchase
 *
 * @phpstan-type PurchaseListResponseShape = array{
 *   limit?: int|null,
 *   purchases?: list<PurchaseShape>|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class PurchaseListResponse implements BaseModel
{
    /** @use SdkModel<PurchaseListResponseShape> */
    use SdkModel;

    /**
     * Limite utilisée.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Tableau des achats.
     *
     * @var list<Purchase>|null $purchases
     */
    #[Optional(list: Purchase::class)]
    public ?array $purchases;

    /**
     * Offset utilisé.
     */
    #[Optional]
    public ?int $skip;

    /**
     * Nombre total d'achats.
     */
    #[Optional]
    public ?int $total;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<PurchaseShape>|null $purchases
     */
    public static function with(
        ?int $limit = null,
        ?array $purchases = null,
        ?int $skip = null,
        ?int $total = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $purchases && $self['purchases'] = $purchases;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Limite utilisée.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Tableau des achats.
     *
     * @param list<PurchaseShape> $purchases
     */
    public function withPurchases(array $purchases): self
    {
        $self = clone $this;
        $self['purchases'] = $purchases;

        return $self;
    }

    /**
     * Offset utilisé.
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Nombre total d'achats.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
