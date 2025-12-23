<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Calcule le chiffre d'affaires sur une période donnée.
 *
 * Basé sur les factures validées (état waiting, paid, late, notpaid).
 * Exclut les avoirs et proformas.
 *
 * @see Wuro\Services\InvoicesService::getTurnover()
 *
 * @phpstan-type InvoiceGetTurnoverParamsShape = array{
 *   maxDate?: \DateTimeInterface|null, minDate?: \DateTimeInterface|null
 * }
 */
final class InvoiceGetTurnoverParams implements BaseModel
{
    /** @use SdkModel<InvoiceGetTurnoverParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Date de fin de la période.
     */
    #[Optional]
    public ?\DateTimeInterface $maxDate;

    /**
     * Date de début de la période.
     */
    #[Optional]
    public ?\DateTimeInterface $minDate;

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
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null
    ): self {
        $self = new self;

        null !== $maxDate && $self['maxDate'] = $maxDate;
        null !== $minDate && $self['minDate'] = $minDate;

        return $self;
    }

    /**
     * Date de fin de la période.
     */
    public function withMaxDate(\DateTimeInterface $maxDate): self
    {
        $self = clone $this;
        $self['maxDate'] = $maxDate;

        return $self;
    }

    /**
     * Date de début de la période.
     */
    public function withMinDate(\DateTimeInterface $minDate): self
    {
        $self = clone $this;
        $self['minDate'] = $minDate;

        return $self;
    }
}
