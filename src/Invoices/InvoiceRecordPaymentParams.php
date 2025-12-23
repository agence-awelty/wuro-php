<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Enregistre un paiement sur une facture en attente.
 *
 * **Restrictions:**
 * - La facture doit être en état 'waiting'
 * - Le mode de paiement doit exister et être actif
 *
 * **Comportement:**
 * - Le paiement est ajouté à la liste `payments` de la facture
 * - Le `total_nettopay` (reste à payer) est recalculé
 * - Si le montant couvre le total, l'état passe à 'paid'
 * - La `payment_date` est mise à jour
 *
 * **Événement déclenché:** PAYMENT_INVOICE
 *
 * @see Wuro\Services\InvoicesService::recordPayment()
 *
 * @phpstan-type InvoiceRecordPaymentParamsShape = array{
 *   amount: float, mode: string
 * }
 */
final class InvoiceRecordPaymentParams implements BaseModel
{
    /** @use SdkModel<InvoiceRecordPaymentParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Montant du paiement.
     */
    #[Required]
    public float $amount;

    /**
     * ID du mode de paiement (PaymentMethod).
     */
    #[Required]
    public string $mode;

    /**
     * `new InvoiceRecordPaymentParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InvoiceRecordPaymentParams::with(amount: ..., mode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InvoiceRecordPaymentParams)->withAmount(...)->withMode(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(float $amount, string $mode): self
    {
        $self = new self;

        $self['amount'] = $amount;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * Montant du paiement.
     */
    public function withAmount(float $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * ID du mode de paiement (PaymentMethod).
     */
    public function withMode(string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }
}
