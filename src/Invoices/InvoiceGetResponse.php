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
 * @phpstan-type InvoiceGetResponseShape = array{
 *   invoice?: null|Invoice|InvoiceShape
 * }
 */
final class InvoiceGetResponse implements BaseModel
{
    /** @use SdkModel<InvoiceGetResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Invoice $invoice;

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
    public static function with(Invoice|array|null $invoice = null): self
    {
        $self = new self;

        null !== $invoice && $self['invoice'] = $invoice;

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
}
