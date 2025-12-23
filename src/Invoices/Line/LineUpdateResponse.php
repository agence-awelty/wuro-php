<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type InvoiceShape from \Wuro\Invoices\Line\Invoice
 * @phpstan-import-type InvoiceLineShape from \Wuro\Invoices\Line\InvoiceLine
 *
 * @phpstan-type LineUpdateResponseShape = array{
 *   invoice?: null|Invoice|InvoiceShape, line?: null|InvoiceLine|InvoiceLineShape
 * }
 */
final class LineUpdateResponse implements BaseModel
{
    /** @use SdkModel<LineUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Invoice $invoice;

    #[Optional]
    public ?InvoiceLine $line;

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
     * @param InvoiceLine|InvoiceLineShape|null $line
     */
    public static function with(
        Invoice|array|null $invoice = null,
        InvoiceLine|array|null $line = null
    ): self {
        $self = new self;

        null !== $invoice && $self['invoice'] = $invoice;
        null !== $line && $self['line'] = $line;

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

    /**
     * @param InvoiceLine|InvoiceLineShape $line
     */
    public function withLine(InvoiceLine|array $line): self
    {
        $self = clone $this;
        $self['line'] = $line;

        return $self;
    }
}
