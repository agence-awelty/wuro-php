<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceListWaitingPaymentsResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceShape = array{
 *   _id?: string|null,
 *   clientName?: string|null,
 *   number?: string|null,
 *   paymentExpiryDate?: \DateTimeInterface|null,
 *   totalNettopay?: float|null,
 * }
 */
final class Invoice implements BaseModel
{
    /** @use SdkModel<InvoiceShape> */
    use SdkModel;

    #[Optional]
    public ?string $_id;

    #[Optional('client_name')]
    public ?string $clientName;

    #[Optional]
    public ?string $number;

    #[Optional('payment_expiry_date')]
    public ?\DateTimeInterface $paymentExpiryDate;

    #[Optional('total_nettopay')]
    public ?float $totalNettopay;

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
        ?string $_id = null,
        ?string $clientName = null,
        ?string $number = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?float $totalNettopay = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $number && $self['number'] = $number;
        null !== $paymentExpiryDate && $self['paymentExpiryDate'] = $paymentExpiryDate;
        null !== $totalNettopay && $self['totalNettopay'] = $totalNettopay;

        return $self;
    }

    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    public function withPaymentExpiryDate(
        \DateTimeInterface $paymentExpiryDate
    ): self {
        $self = clone $this;
        $self['paymentExpiryDate'] = $paymentExpiryDate;

        return $self;
    }

    public function withTotalNettopay(float $totalNettopay): self
    {
        $self = clone $this;
        $self['totalNettopay'] = $totalNettopay;

        return $self;
    }
}
