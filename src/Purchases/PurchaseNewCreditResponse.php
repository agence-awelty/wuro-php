<?php

declare(strict_types=1);

namespace Wuro\Purchases;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PurchaseShape from \Wuro\Purchases\Purchase
 *
 * @phpstan-type PurchaseNewCreditResponseShape = array{
 *   newPurchase?: null|Purchase|PurchaseShape
 * }
 */
final class PurchaseNewCreditResponse implements BaseModel
{
    /** @use SdkModel<PurchaseNewCreditResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Purchase $newPurchase;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Purchase|PurchaseShape|null $newPurchase
     */
    public static function with(Purchase|array|null $newPurchase = null): self
    {
        $self = new self;

        null !== $newPurchase && $self['newPurchase'] = $newPurchase;

        return $self;
    }

    /**
     * @param Purchase|PurchaseShape $newPurchase
     */
    public function withNewPurchase(Purchase|array $newPurchase): self
    {
        $self = clone $this;
        $self['newPurchase'] = $newPurchase;

        return $self;
    }
}
