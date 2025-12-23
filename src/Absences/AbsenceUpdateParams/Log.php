<?php

declare(strict_types=1);

namespace Wuro\Absences\AbsenceUpdateParams;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type LogShape = array{
 *   comment?: string|null,
 *   date?: \DateTimeInterface|null,
 *   file?: string|null,
 *   method?: string|null,
 *   position?: string|null,
 *   state?: string|null,
 * }
 */
final class Log implements BaseModel
{
    /** @use SdkModel<LogShape> */
    use SdkModel;

    /**
     * Commentaire (motif de refus, remarque, etc.).
     */
    #[Optional]
    public ?string $comment;

    /**
     * Date de l'action.
     */
    #[Optional]
    public ?\DateTimeInterface $date;

    /**
     * Pièce jointe (justificatif, certificat médical, etc.).
     */
    #[Optional]
    public ?string $file;

    /**
     * Méthode HTTP (GET, PATCH, DELETE).
     */
    #[Optional]
    public ?string $method;

    /**
     * Poste ayant effectué l'action.
     */
    #[Optional]
    public ?string $position;

    /**
     * État après l'action.
     */
    #[Optional]
    public ?string $state;

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
        ?\DateTimeInterface $date = null,
        ?string $file = null,
        ?string $method = null,
        ?string $position = null,
        ?string $state = null,
    ): self {
        $self = new self;

        null !== $comment && $self['comment'] = $comment;
        null !== $date && $self['date'] = $date;
        null !== $file && $self['file'] = $file;
        null !== $method && $self['method'] = $method;
        null !== $position && $self['position'] = $position;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    /**
     * Commentaire (motif de refus, remarque, etc.).
     */
    public function withComment(string $comment): self
    {
        $self = clone $this;
        $self['comment'] = $comment;

        return $self;
    }

    /**
     * Date de l'action.
     */
    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

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

    /**
     * Méthode HTTP (GET, PATCH, DELETE).
     */
    public function withMethod(string $method): self
    {
        $self = clone $this;
        $self['method'] = $method;

        return $self;
    }

    /**
     * Poste ayant effectué l'action.
     */
    public function withPosition(string $position): self
    {
        $self = clone $this;
        $self['position'] = $position;

        return $self;
    }

    /**
     * État après l'action.
     */
    public function withState(string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
