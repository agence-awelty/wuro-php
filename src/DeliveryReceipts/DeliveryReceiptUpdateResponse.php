<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ReceiptShape from \Wuro\DeliveryReceipts\Receipt
 *
 * @phpstan-type DeliveryReceiptUpdateResponseShape = array{
 *   updatedReceipt?: null|Receipt|ReceiptShape
 * }
 */
final class DeliveryReceiptUpdateResponse implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Receipt $updatedReceipt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Receipt|ReceiptShape|null $updatedReceipt
     */
    public static function with(Receipt|array|null $updatedReceipt = null): self
    {
        $self = new self;

        null !== $updatedReceipt && $self['updatedReceipt'] = $updatedReceipt;

        return $self;
    }

    /**
     * @param Receipt|ReceiptShape $updatedReceipt
     */
    public function withUpdatedReceipt(Receipt|array $updatedReceipt): self
    {
        $self = clone $this;
        $self['updatedReceipt'] = $updatedReceipt;

        return $self;
    }
}
