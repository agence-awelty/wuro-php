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
 * @phpstan-type InvoiceNewCreditResponseShape = array{
 *   newInvoice?: null|Invoice|InvoiceShape
 * }
 */
final class InvoiceNewCreditResponse implements BaseModel
{
    /** @use SdkModel<InvoiceNewCreditResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Invoice $newInvoice;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Invoice|InvoiceShape|null $newInvoice
     */
    public static function with(Invoice|array|null $newInvoice = null): self
    {
        $self = new self;

        null !== $newInvoice && $self['newInvoice'] = $newInvoice;

        return $self;
    }

    /**
     * @param Invoice|InvoiceShape $newInvoice
     */
    public function withNewInvoice(Invoice|array $newInvoice): self
    {
        $self = clone $this;
        $self['newInvoice'] = $newInvoice;

        return $self;
    }
}
