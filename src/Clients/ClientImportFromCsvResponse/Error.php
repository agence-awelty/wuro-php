<?php

declare(strict_types=1);

namespace Wuro\Clients\ClientImportFromCsvResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type ErrorShape = array{line?: int|null, message?: string|null}
 */
final class Error implements BaseModel
{
    /** @use SdkModel<ErrorShape> */
    use SdkModel;

    /**
     * Numéro de ligne en erreur.
     */
    #[Optional]
    public ?int $line;

    /**
     * Message d'erreur.
     */
    #[Optional]
    public ?string $message;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $line = null, ?string $message = null): self
    {
        $self = new self;

        null !== $line && $self['line'] = $line;
        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * Numéro de ligne en erreur.
     */
    public function withLine(int $line): self
    {
        $self = clone $this;
        $self['line'] = $line;

        return $self;
    }

    /**
     * Message d'erreur.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
