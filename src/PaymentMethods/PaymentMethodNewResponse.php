<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PaymentMethodShape from \Wuro\PaymentMethods\PaymentMethod
 *
 * @phpstan-type PaymentMethodNewResponseShape = array{
 *   newPaymentMethod?: null|PaymentMethod|PaymentMethodShape
 * }
 */
final class PaymentMethodNewResponse implements BaseModel
{
    /** @use SdkModel<PaymentMethodNewResponseShape> */
    use SdkModel;

    #[Optional]
    public ?PaymentMethod $newPaymentMethod;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param PaymentMethod|PaymentMethodShape|null $newPaymentMethod
     */
    public static function with(
        PaymentMethod|array|null $newPaymentMethod = null
    ): self {
        $self = new self;

        null !== $newPaymentMethod && $self['newPaymentMethod'] = $newPaymentMethod;

        return $self;
    }

    /**
     * @param PaymentMethod|PaymentMethodShape $newPaymentMethod
     */
    public function withNewPaymentMethod(
        PaymentMethod|array $newPaymentMethod
    ): self {
        $self = clone $this;
        $self['newPaymentMethod'] = $newPaymentMethod;

        return $self;
    }
}
