<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceListWaitingPaymentsResponse\Invoice;

/**
 * @phpstan-import-type InvoiceShape from \Wuro\Invoices\InvoiceListWaitingPaymentsResponse\Invoice
 *
 * @phpstan-type InvoiceListWaitingPaymentsResponseShape = array{
 *   invoices?: list<InvoiceShape>|null, total?: int|null, totalAmount?: float|null
 * }
 */
final class InvoiceListWaitingPaymentsResponse implements BaseModel
{
    /** @use SdkModel<InvoiceListWaitingPaymentsResponseShape> */
    use SdkModel;

    /** @var list<Invoice>|null $invoices */
    #[Optional(list: Invoice::class)]
    public ?array $invoices;

    #[Optional]
    public ?int $total;

    /**
     * Somme des montants restant à payer.
     */
    #[Optional]
    public ?float $totalAmount;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<InvoiceShape>|null $invoices
     */
    public static function with(
        ?array $invoices = null,
        ?int $total = null,
        ?float $totalAmount = null
    ): self {
        $self = new self;

        null !== $invoices && $self['invoices'] = $invoices;
        null !== $total && $self['total'] = $total;
        null !== $totalAmount && $self['totalAmount'] = $totalAmount;

        return $self;
    }

    /**
     * @param list<InvoiceShape> $invoices
     */
    public function withInvoices(array $invoices): self
    {
        $self = clone $this;
        $self['invoices'] = $invoices;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    /**
     * Somme des montants restant à payer.
     */
    public function withTotalAmount(float $totalAmount): self
    {
        $self = clone $this;
        $self['totalAmount'] = $totalAmount;

        return $self;
    }
}
