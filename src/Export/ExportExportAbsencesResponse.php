<?php

declare(strict_types=1);

namespace Wuro\Export;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExportExportAbsencesResponseShape = array{
 *   message?: string|null, package?: mixed
 * }
 */
final class ExportExportAbsencesResponse implements BaseModel
{
    /** @use SdkModel<ExportExportAbsencesResponseShape> */
    use SdkModel;

    /**
     * Success message.
     */
    #[Optional]
    public ?string $message;

    /**
     * Package information.
     */
    #[Optional]
    public mixed $package;

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
        mixed $package = null
    ): self {
        $self = new self;

        null !== $message && $self['message'] = $message;
        null !== $package && $self['package'] = $package;

        return $self;
    }

    /**
     * Success message.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Package information.
     */
    public function withPackage(mixed $package): self
    {
        $self = clone $this;
        $self['package'] = $package;

        return $self;
    }
}
