<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceNewPackageResponseShape = array{
 *   message?: string|null, newPackage?: mixed
 * }
 */
final class InvoiceNewPackageResponse implements BaseModel
{
    /** @use SdkModel<InvoiceNewPackageResponseShape> */
    use SdkModel;

    #[Optional]
    public ?string $message;

    /**
     * Objet Package avec état et URL.
     */
    #[Optional]
    public mixed $newPackage;

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
        ?string $message = null,
        mixed $newPackage = null
    ): self {
        $self = new self;

        null !== $message && $self['message'] = $message;
        null !== $newPackage && $self['newPackage'] = $newPackage;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Objet Package avec état et URL.
     */
    public function withNewPackage(mixed $newPackage): self
    {
        $self = clone $this;
        $self['newPackage'] = $newPackage;

        return $self;
    }
}
