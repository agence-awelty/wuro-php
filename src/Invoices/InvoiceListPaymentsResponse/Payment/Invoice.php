<?php

declare(strict_types=1);

namespace Wuro\Invoices\InvoiceListPaymentsResponse\Payment;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceShape = array{
 *   clientName?: string|null, invoiceID?: string|null, number?: string|null
 * }
 */
final class Invoice implements BaseModel
{
    /** @use SdkModel<InvoiceShape> */
    use SdkModel;

    #[Optional('client_name')]
    public ?string $clientName;

    #[Optional('invoice_id')]
    public ?string $invoiceID;

    #[Optional]
    public ?string $number;

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
        ?string $clientName = null,
        ?string $invoiceID = null,
        ?string $number = null
    ): self {
        $self = new self;

        null !== $clientName && $self['clientName'] = $clientName;
        null !== $invoiceID && $self['invoiceID'] = $invoiceID;
        null !== $number && $self['number'] = $number;

        return $self;
    }

    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    public function withInvoiceID(string $invoiceID): self
    {
        $self = clone $this;
        $self['invoiceID'] = $invoiceID;

        return $self;
    }

    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }
}
