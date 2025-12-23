<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ReceiptShape from \Wuro\DeliveryReceipts\Receipt
 *
 * @phpstan-type DeliveryReceiptGetResponseShape = array{
 *   receipt?: null|Receipt|ReceiptShape
 * }
 */
final class DeliveryReceiptGetResponse implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptGetResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Receipt $receipt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Receipt|ReceiptShape|null $receipt
     */
    public static function with(Receipt|array|null $receipt = null): self
    {
        $self = new self;

        null !== $receipt && $self['receipt'] = $receipt;

        return $self;
    }

    /**
     * @param Receipt|ReceiptShape $receipt
     */
    public function withReceipt(Receipt|array $receipt): self
    {
        $self = clone $this;
        $self['receipt'] = $receipt;

        return $self;
    }
}
