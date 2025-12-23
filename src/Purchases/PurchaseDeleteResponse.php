<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PurchaseShape from \Wuro\Purchases\Purchase
 *
 * @phpstan-type PurchaseDeleteResponseShape = array{
 *   purchase?: null|Purchase|PurchaseShape
 * }
 */
final class PurchaseDeleteResponse implements BaseModel
{
    /** @use SdkModel<PurchaseDeleteResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Purchase $purchase;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Purchase|PurchaseShape|null $purchase
     */
    public static function with(Purchase|array|null $purchase = null): self
    {
        $self = new self;

        null !== $purchase && $self['purchase'] = $purchase;

        return $self;
    }

    /**
     * @param Purchase|PurchaseShape $purchase
     */
    public function withPurchase(Purchase|array $purchase): self
    {
        $self = clone $this;
        $self['purchase'] = $purchase;

        return $self;
    }
}
