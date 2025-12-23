<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ReceiptShape from \Wuro\DeliveryReceipts\Receipt
 *
 * @phpstan-type DeliveryReceiptNewResponseShape = array{
 *   newReceipt?: null|Receipt|ReceiptShape
 * }
 */
final class DeliveryReceiptNewResponse implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptNewResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Receipt $newReceipt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Receipt|ReceiptShape|null $newReceipt
     */
    public static function with(Receipt|array|null $newReceipt = null): self
    {
        $self = new self;

        null !== $newReceipt && $self['newReceipt'] = $newReceipt;

        return $self;
    }

    /**
     * @param Receipt|ReceiptShape $newReceipt
     */
    public function withNewReceipt(Receipt|array $newReceipt): self
    {
        $self = clone $this;
        $self['newReceipt'] = $newReceipt;

        return $self;
    }
}
