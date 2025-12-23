<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ReceiptShape from \Wuro\DeliveryReceipts\Receipt
 *
 * @phpstan-type DeliveryReceiptListResponseShape = array{
 *   limit?: int|null,
 *   receipts?: list<ReceiptShape>|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class DeliveryReceiptListResponse implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptListResponseShape> */
    use SdkModel;

    #[Optional]
    public ?int $limit;

    /** @var list<Receipt>|null $receipts */
    #[Optional(list: Receipt::class)]
    public ?array $receipts;

    #[Optional]
    public ?int $skip;

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
     * @param list<ReceiptShape>|null $receipts
     */
    public static function with(
        ?int $limit = null,
        ?array $receipts = null,
        ?int $skip = null,
        ?int $total = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $receipts && $self['receipts'] = $receipts;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * @param list<ReceiptShape> $receipts
     */
    public function withReceipts(array $receipts): self
    {
        $self = clone $this;
        $self['receipts'] = $receipts;

        return $self;
    }

    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
