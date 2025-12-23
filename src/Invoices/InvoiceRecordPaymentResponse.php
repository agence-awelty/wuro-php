<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\Line\Invoice;

/**
 * @phpstan-import-type InvoiceShape from \Wuro\Invoices\Line\Invoice
 *
 * @phpstan-type InvoiceRecordPaymentResponseShape = array{
 *   updatedInvoice?: null|Invoice|InvoiceShape
 * }
 */
final class InvoiceRecordPaymentResponse implements BaseModel
{
    /** @use SdkModel<InvoiceRecordPaymentResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Invoice $updatedInvoice;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Invoice|InvoiceShape|null $updatedInvoice
     */
    public static function with(Invoice|array|null $updatedInvoice = null): self
    {
        $self = new self;

        null !== $updatedInvoice && $self['updatedInvoice'] = $updatedInvoice;

        return $self;
    }

    /**
     * @param Invoice|InvoiceShape $updatedInvoice
     */
    public function withUpdatedInvoice(Invoice|array $updatedInvoice): self
    {
        $self = clone $this;
        $self['updatedInvoice'] = $updatedInvoice;

        return $self;
    }
}
