<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceListPaymentsResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceListPaymentsResponse\Payment\Invoice;

/**
 * @phpstan-import-type InvoiceShape from \Wuro\Invoices\InvoiceListPaymentsResponse\Payment\Invoice
 *
 * @phpstan-type PaymentShape = array{
 *   amount?: float|null,
 *   date?: \DateTimeInterface|null,
 *   invoice?: null|Invoice|InvoiceShape,
 *   methodName?: string|null,
 * }
 */
final class Payment implements BaseModel
{
    /** @use SdkModel<PaymentShape> */
    use SdkModel;

    #[Optional]
    public ?float $amount;

    #[Optional]
    public ?\DateTimeInterface $date;

    #[Optional]
    public ?Invoice $invoice;

    #[Optional('method_name')]
    public ?string $methodName;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Invoice|InvoiceShape|null $invoice
     */
    public static function with(
        ?float $amount = null,
        ?\DateTimeInterface $date = null,
        Invoice|array|null $invoice = null,
        ?string $methodName = null,
    ): self {
        $self = new self;

        null !== $amount && $self['amount'] = $amount;
        null !== $date && $self['date'] = $date;
        null !== $invoice && $self['invoice'] = $invoice;
        null !== $methodName && $self['methodName'] = $methodName;

        return $self;
    }

    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * @param Invoice|InvoiceShape $invoice
     */
    public function withInvoice(Invoice|array $invoice): self
    {
        $self = clone $this;
        $self['invoice'] = $invoice;

        return $self;
    }

    public function withMethodName(string $methodName): self
    {
        $self = clone $this;
        $self['methodName'] = $methodName;

        return $self;
    }
}
