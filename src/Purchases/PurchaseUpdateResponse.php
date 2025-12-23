<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PurchaseShape from \Wuro\Purchases\Purchase
 *
 * @phpstan-type PurchaseUpdateResponseShape = array{
 *   updatedPurchase?: null|Purchase|PurchaseShape
 * }
 */
final class PurchaseUpdateResponse implements BaseModel
{
    /** @use SdkModel<PurchaseUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Purchase $updatedPurchase;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Purchase|PurchaseShape|null $updatedPurchase
     */
    public static function with(Purchase|array|null $updatedPurchase = null): self
    {
        $self = new self;

        null !== $updatedPurchase && $self['updatedPurchase'] = $updatedPurchase;

        return $self;
    }

    /**
     * @param Purchase|PurchaseShape $updatedPurchase
     */
    public function withUpdatedPurchase(Purchase|array $updatedPurchase): self
    {
        $self = clone $this;
        $self['updatedPurchase'] = $updatedPurchase;

        return $self;
    }
}
