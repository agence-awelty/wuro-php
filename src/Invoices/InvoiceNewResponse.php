<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceNewResponse\NewInvoice;

/**
 * @phpstan-import-type NewInvoiceShape from \Wuro\Invoices\InvoiceNewResponse\NewInvoice
 *
 * @phpstan-type InvoiceNewResponseShape = array{
 *   newInvoice?: null|NewInvoice|NewInvoiceShape
 * }
 */
final class InvoiceNewResponse implements BaseModel
{
    /** @use SdkModel<InvoiceNewResponseShape> */
    use SdkModel;

    #[Optional]
    public ?NewInvoice $newInvoice;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param NewInvoice|NewInvoiceShape|null $newInvoice
     */
    public static function with(NewInvoice|array|null $newInvoice = null): self
    {
        $self = new self;

        null !== $newInvoice && $self['newInvoice'] = $newInvoice;

        return $self;
    }

    /**
     * @param NewInvoice|NewInvoiceShape $newInvoice
     */
    public function withNewInvoice(NewInvoice|array $newInvoice): self
    {
        $self = clone $this;
        $self['newInvoice'] = $newInvoice;

        return $self;
    }
}
