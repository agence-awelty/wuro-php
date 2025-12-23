<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceCreateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type LogShape = array{comment?: string|null, file?: string|null}
 */
final class Log implements BaseModel
{
    /** @use SdkModel<LogShape> */
    use SdkModel;

    /**
     * Commentaire (motif de l'absence, etc.).
     */
    #[Optional]
    public ?string $comment;

    /**
     * Pièce jointe (justificatif, certificat médical, etc.).
     */
    #[Optional]
    public ?string $file;

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
        ?string $comment = null,
        ?string $file = null
    ): self {
        $self = new self;

        null !== $comment && $self['comment'] = $comment;
        null !== $file && $self['file'] = $file;

        return $self;
    }

    /**
     * Commentaire (motif de l'absence, etc.).
     */
    public function withComment(string $comment): self
    {
        $self = clone $this;
        $self['comment'] = $comment;

        return $self;
    }

    /**
     * Pièce jointe (justificatif, certificat médical, etc.).
     */
    public function withFile(string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }
}
