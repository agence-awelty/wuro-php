<?php

declare(strict_types=1);

namespace Wuro\Companies\AppInfos\CompanyApp;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type StripeCustomerIDShape = array{
 *   dev?: string|null, preprod?: string|null, prod?: string|null
 * }
 */
final class StripeCustomerID implements BaseModel
{
    /** @use SdkModel<StripeCustomerIDShape> */
    use SdkModel;

    /**
     * Development Stripe customer ID.
     */
    #[Optional]
    public ?string $dev;

    /**
     * Pre-production Stripe customer ID.
     */
    #[Optional]
    public ?string $preprod;

    /**
     * Production Stripe customer ID.
     */
    #[Optional]
    public ?string $prod;

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
        ?string $dev = null,
        ?string $preprod = null,
        ?string $prod = null
    ): self {
        $self = new self;

        null !== $dev && $self['dev'] = $dev;
        null !== $preprod && $self['preprod'] = $preprod;
        null !== $prod && $self['prod'] = $prod;

        return $self;
    }

    /**
     * Development Stripe customer ID.
     */
    public function withDev(string $dev): self
    {
        $self = clone $this;
        $self['dev'] = $dev;

        return $self;
    }

    /**
     * Pre-production Stripe customer ID.
     */
    public function withPreprod(string $preprod): self
    {
        $self = clone $this;
        $self['preprod'] = $preprod;

        return $self;
    }

    /**
     * Production Stripe customer ID.
     */
    public function withProd(string $prod): self
    {
        $self = clone $this;
        $self['prod'] = $prod;

        return $self;
    }
}
