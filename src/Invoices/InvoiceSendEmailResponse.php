<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvoiceSendEmailResponseShape = array{
 *   html?: string|null, resultID?: string|null, subject?: string|null
 * }
 */
final class InvoiceSendEmailResponse implements BaseModel
{
    /** @use SdkModel<InvoiceSendEmailResponseShape> */
    use SdkModel;

    /**
     * Contenu HTML de l'email.
     */
    #[Optional]
    public ?string $html;

    /**
     * ID de l'email envoyé.
     */
    #[Optional('resultId')]
    public ?string $resultID;

    #[Optional]
    public ?string $subject;

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
        ?string $html = null,
        ?string $resultID = null,
        ?string $subject = null
    ): self {
        $self = new self;

        null !== $html && $self['html'] = $html;
        null !== $resultID && $self['resultID'] = $resultID;
        null !== $subject && $self['subject'] = $subject;

        return $self;
    }

    /**
     * Contenu HTML de l'email.
     */
    public function withHTML(string $html): self
    {
        $self = clone $this;
        $self['html'] = $html;

        return $self;
    }

    /**
     * ID de l'email envoyé.
     */
    public function withResultID(string $resultID): self
    {
        $self = clone $this;
        $self['resultID'] = $resultID;

        return $self;
    }

    public function withSubject(string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }
}
