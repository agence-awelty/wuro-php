<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceListPaymentsResponse\Payment;

/**
 * @phpstan-import-type PaymentShape from \Wuro\Invoices\InvoiceListPaymentsResponse\Payment
 *
 * @phpstan-type InvoiceListPaymentsResponseShape = array{
 *   average?: float|null,
 *   count?: int|null,
 *   payments?: list<PaymentShape>|null,
 *   total?: float|null,
 * }
 */
final class InvoiceListPaymentsResponse implements BaseModel
{
    /** @use SdkModel<InvoiceListPaymentsResponseShape> */
    use SdkModel;

    /**
     * Moyenne des montants.
     */
    #[Optional]
    public ?float $average;

    /**
     * Nombre total de paiements.
     */
    #[Optional]
    public ?int $count;

    /** @var list<Payment>|null $payments */
    #[Optional(list: Payment::class)]
    public ?array $payments;

    /**
     * Somme des montants.
     */
    #[Optional]
    public ?float $total;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<PaymentShape>|null $payments
     */
    public static function with(
        ?float $average = null,
        ?int $count = null,
        ?array $payments = null,
        ?float $total = null,
    ): self {
        $self = new self;

        null !== $average && $self['average'] = $average;
        null !== $count && $self['count'] = $count;
        null !== $payments && $self['payments'] = $payments;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Moyenne des montants.
     */
    public function withAverage(float $average): self
    {
        $self = clone $this;
        $self['average'] = $average;

        return $self;
    }

    /**
     * Nombre total de paiements.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * @param list<PaymentShape> $payments
     */
    public function withPayments(array $payments): self
    {
        $self = clone $this;
        $self['payments'] = $payments;

        return $self;
    }

    /**
     * Somme des montants.
     */
    public function withTotal(float $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
