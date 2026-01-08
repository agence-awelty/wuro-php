<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PaymentMethodShape from \Wuro\PaymentMethods\PaymentMethod
 *
 * @phpstan-type PaymentMethodListResponseShape = array{
 *   paymentMethods?: list<PaymentMethod|PaymentMethodShape>|null, total?: int|null
 * }
 */
final class PaymentMethodListResponse implements BaseModel
{
    /** @use SdkModel<PaymentMethodListResponseShape> */
    use SdkModel;

    /**
     * Tableau des moyens de paiement.
     *
     * @var list<PaymentMethod>|null $paymentMethods
     */
    #[Optional(list: PaymentMethod::class)]
    public ?array $paymentMethods;

    /**
     * Nombre total de moyens de paiement.
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
     * @param list<PaymentMethod|PaymentMethodShape>|null $paymentMethods
     */
    public static function with(
        ?array $paymentMethods = null,
        ?int $total = null
    ): self {
        $self = new self;

        null !== $paymentMethods && $self['paymentMethods'] = $paymentMethods;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Tableau des moyens de paiement.
     *
     * @param list<PaymentMethod|PaymentMethodShape> $paymentMethods
     */
    public function withPaymentMethods(array $paymentMethods): self
    {
        $self = clone $this;
        $self['paymentMethods'] = $paymentMethods;

        return $self;
    }

    /**
     * Nombre total de moyens de paiement.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
