<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Génère une facture d'acompte à partir d'un devis.
 *
 * **Options:**
 * - Spécifier un montant ou un pourcentage de l'acompte
 * - L'acompte est lié au devis d'origine
 *
 * @see Wuro\Services\QuotesService::createAdvanceInvoice()
 *
 * @phpstan-type QuoteCreateAdvanceInvoiceParamsShape = array{
 *   amount?: float|null, percentage?: float|null
 * }
 */
final class QuoteCreateAdvanceInvoiceParams implements BaseModel
{
    /** @use SdkModel<QuoteCreateAdvanceInvoiceParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Montant de l'acompte.
     */
    #[Optional]
    public ?float $amount;

    /**
     * Pourcentage de l'acompte.
     */
    #[Optional]
    public ?float $percentage;

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
        ?float $amount = null,
        ?float $percentage = null
    ): self {
        $self = new self;

        null !== $amount && $self['amount'] = $amount;
        null !== $percentage && $self['percentage'] = $percentage;

        return $self;
    }

    /**
     * Montant de l'acompte.
     */
    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * Pourcentage de l'acompte.
     */
    public function withPercentage(float $percentage): self
    {
        $self = clone $this;
        $self['percentage'] = $percentage;

        return $self;
    }
}
