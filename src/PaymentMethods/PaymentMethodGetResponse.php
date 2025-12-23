<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PaymentMethodShape from \Wuro\PaymentMethods\PaymentMethod
 *
 * @phpstan-type PaymentMethodGetResponseShape = array{
 *   paymentMethod?: null|PaymentMethod|PaymentMethodShape
 * }
 */
final class PaymentMethodGetResponse implements BaseModel
{
    /** @use SdkModel<PaymentMethodGetResponseShape> */
    use SdkModel;

    #[Optional]
    public ?PaymentMethod $paymentMethod;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param PaymentMethod|PaymentMethodShape|null $paymentMethod
     */
    public static function with(PaymentMethod|array|null $paymentMethod = null): self
    {
        $self = new self;

        null !== $paymentMethod && $self['paymentMethod'] = $paymentMethod;

        return $self;
    }

    /**
     * @param PaymentMethod|PaymentMethodShape $paymentMethod
     */
    public function withPaymentMethod(PaymentMethod|array $paymentMethod): self
    {
        $self = clone $this;
        $self['paymentMethod'] = $paymentMethod;

        return $self;
    }
}
