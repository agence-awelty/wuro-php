<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PaymentMethodShape from \Wuro\PaymentMethods\PaymentMethod
 *
 * @phpstan-type PaymentMethodUpdateResponseShape = array{
 *   updatedPaymentMethod?: null|PaymentMethod|PaymentMethodShape
 * }
 */
final class PaymentMethodUpdateResponse implements BaseModel
{
    /** @use SdkModel<PaymentMethodUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?PaymentMethod $updatedPaymentMethod;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param PaymentMethod|PaymentMethodShape|null $updatedPaymentMethod
     */
    public static function with(
        PaymentMethod|array|null $updatedPaymentMethod = null
    ): self {
        $self = new self;

        null !== $updatedPaymentMethod && $self['updatedPaymentMethod'] = $updatedPaymentMethod;

        return $self;
    }

    /**
     * @param PaymentMethod|PaymentMethodShape $updatedPaymentMethod
     */
    public function withUpdatedPaymentMethod(
        PaymentMethod|array $updatedPaymentMethod
    ): self {
        $self = clone $this;
        $self['updatedPaymentMethod'] = $updatedPaymentMethod;

        return $self;
    }
}
