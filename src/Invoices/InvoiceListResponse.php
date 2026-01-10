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
 * @phpstan-type InvoiceListResponseShape = array{
 *   invoices?: list<Invoice|InvoiceShape>|null,
 *   limit?: int|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class InvoiceListResponse implements BaseModel
{
    /** @use SdkModel<InvoiceListResponseShape> */
    use SdkModel;

    /** @var list<Invoice>|null $invoices */
    #[Optional(list: Invoice::class)]
    public ?array $invoices;

    #[Optional]
    public ?int $limit;

    #[Optional]
    public ?int $skip;

    /**
     * Nombre total de factures.
     */
    #[Optional]
    public ?int $total;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Invoice|InvoiceShape>|null $invoices
     */
    public static function with(
        ?array $invoices = null,
        ?int $limit = null,
        ?int $skip = null,
        ?int $total = null,
    ): self {
        $self = new self;

        null !== $invoices && $self['invoices'] = $invoices;
        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * @param list<Invoice|InvoiceShape> $invoices
     */
    public function withInvoices(array $invoices): self
    {
        $self = clone $this;
        $self['invoices'] = $invoices;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Nombre total de factures.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
