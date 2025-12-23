<?php

declare(strict_types=1);

namespace Wuro\InvoiceFile;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceFileAnalyzeResponseShape = array{
 *   invoice?: mixed, preSubmitInvoice?: mixed
 * }
 */
final class InvoiceFileAnalyzeResponse implements BaseModel
{
    /** @use SdkModel<InvoiceFileAnalyzeResponseShape> */
    use SdkModel;

    /**
     * Données brutes extraites.
     */
    #[Optional]
    public mixed $invoice;

    /**
     * Données avec totaux recalculés.
     */
    #[Optional]
    public mixed $preSubmitInvoice;

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
        mixed $invoice = null,
        mixed $preSubmitInvoice = null
    ): self {
        $self = new self;

        null !== $invoice && $self['invoice'] = $invoice;
        null !== $preSubmitInvoice && $self['preSubmitInvoice'] = $preSubmitInvoice;

        return $self;
    }

    /**
     * Données brutes extraites.
     */
    public function withInvoice(mixed $invoice): self
    {
        $self = clone $this;
        $self['invoice'] = $invoice;

        return $self;
    }

    /**
     * Données avec totaux recalculés.
     */
    public function withPreSubmitInvoice(mixed $preSubmitInvoice): self
    {
        $self = clone $this;
        $self['preSubmitInvoice'] = $preSubmitInvoice;

        return $self;
    }
}
