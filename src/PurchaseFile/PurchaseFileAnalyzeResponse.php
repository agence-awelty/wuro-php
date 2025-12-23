<?php

declare(strict_types=1);

namespace Wuro\PurchaseFile;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type PurchaseFileAnalyzeResponseShape = array{
 *   preSubmitPurchase?: mixed, purchase?: mixed
 * }
 */
final class PurchaseFileAnalyzeResponse implements BaseModel
{
    /** @use SdkModel<PurchaseFileAnalyzeResponseShape> */
    use SdkModel;

    /**
     * Données avec totaux recalculés.
     */
    #[Optional]
    public mixed $preSubmitPurchase;

    /**
     * Données brutes extraites.
     */
    #[Optional]
    public mixed $purchase;

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
        mixed $preSubmitPurchase = null,
        mixed $purchase = null
    ): self {
        $self = new self;

        null !== $preSubmitPurchase && $self['preSubmitPurchase'] = $preSubmitPurchase;
        null !== $purchase && $self['purchase'] = $purchase;

        return $self;
    }

    /**
     * Données avec totaux recalculés.
     */
    public function withPreSubmitPurchase(mixed $preSubmitPurchase): self
    {
        $self = clone $this;
        $self['preSubmitPurchase'] = $preSubmitPurchase;

        return $self;
    }

    /**
     * Données brutes extraites.
     */
    public function withPurchase(mixed $purchase): self
    {
        $self = clone $this;
        $self['purchase'] = $purchase;

        return $self;
    }
}
