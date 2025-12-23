<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les logs d'actions effectuées sur les factures (création, modification, envoi, etc.).
 *
 * Utile pour l'audit et le suivi des modifications.
 *
 * @see Wuro\Services\InvoicesService::getLogs()
 *
 * @phpstan-type InvoiceGetLogsParamsShape = array{
 *   invoice?: string|null, limit?: int|null, skip?: int|null
 * }
 */
final class InvoiceGetLogsParams implements BaseModel
{
    /** @use SdkModel<InvoiceGetLogsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filtre par ID de facture.
     */
    #[Optional]
    public ?string $invoice;

    #[Optional]
    public ?int $limit;

    #[Optional]
    public ?int $skip;

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
        ?string $invoice = null,
        ?int $limit = null,
        ?int $skip = null
    ): self {
        $self = new self;

        null !== $invoice && $self['invoice'] = $invoice;
        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;

        return $self;
    }

    /**
     * Filtre par ID de facture.
     */
    public function withInvoice(string $invoice): self
    {
        $self = clone $this;
        $self['invoice'] = $invoice;

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
}
