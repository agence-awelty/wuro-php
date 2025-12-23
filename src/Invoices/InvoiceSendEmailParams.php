<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\Invoices\InvoiceSendEmailParams\Action;

/**
 * Envoie la facture par email au client.
 *
 * **Restrictions:**
 * - La facture ne doit pas être en brouillon
 *
 * **Personnalisation:**
 * - Utilise les modèles d'email configurés dans l'entreprise
 * - Variables disponibles: [lien-html], [lien-pdf], [facture-numero], [facture-date], [contact-nom], etc.
 *
 * **Options:**
 * - `action`: 'send_invoice' (envoi standard) ou 'dunning_invoice' (relance)
 * - `joinPdf`: true pour joindre le PDF en pièce jointe
 * - Possibilité de personnaliser subject, content, to, copyto, replyTo
 *
 * @see Wuro\Services\InvoicesService::sendEmail()
 *
 * @phpstan-type InvoiceSendEmailParamsShape = array{
 *   action?: null|Action|value-of<Action>,
 *   content?: string|null,
 *   copyto?: string|null,
 *   joinPdf?: bool|null,
 *   replyTo?: string|null,
 *   subject?: string|null,
 *   to?: string|null,
 * }
 */
final class InvoiceSendEmailParams implements BaseModel
{
    /** @use SdkModel<InvoiceSendEmailParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Type d'envoi (envoi ou relance).
     *
     * @var value-of<Action>|null $action
     */
    #[Optional(enum: Action::class)]
    public ?string $action;

    /**
     * Contenu personnalisé.
     */
    #[Optional]
    public ?string $content;

    /**
     * Email en copie.
     */
    #[Optional]
    public ?string $copyto;

    /**
     * Joindre le PDF en pièce jointe.
     */
    #[Optional]
    public ?bool $joinPdf;

    /**
     * Email pour les réponses.
     */
    #[Optional]
    public ?string $replyTo;

    /**
     * Objet personnalisé.
     */
    #[Optional]
    public ?string $subject;

    /**
     * Email du destinataire (défaut = email du client).
     */
    #[Optional]
    public ?string $to;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Action|value-of<Action>|null $action
     */
    public static function with(
        Action|string|null $action = null,
        ?string $content = null,
        ?string $copyto = null,
        ?bool $joinPdf = null,
        ?string $replyTo = null,
        ?string $subject = null,
        ?string $to = null,
    ): self {
        $self = new self;

        null !== $action && $self['action'] = $action;
        null !== $content && $self['content'] = $content;
        null !== $copyto && $self['copyto'] = $copyto;
        null !== $joinPdf && $self['joinPdf'] = $joinPdf;
        null !== $replyTo && $self['replyTo'] = $replyTo;
        null !== $subject && $self['subject'] = $subject;
        null !== $to && $self['to'] = $to;

        return $self;
    }

    /**
     * Type d'envoi (envoi ou relance).
     *
     * @param Action|value-of<Action> $action
     */
    public function withAction(Action|string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * Contenu personnalisé.
     */
    public function withContent(string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Email en copie.
     */
    public function withCopyto(string $copyto): self
    {
        $self = clone $this;
        $self['copyto'] = $copyto;

        return $self;
    }

    /**
     * Joindre le PDF en pièce jointe.
     */
    public function withJoinPdf(bool $joinPdf): self
    {
        $self = clone $this;
        $self['joinPdf'] = $joinPdf;

        return $self;
    }

    /**
     * Email pour les réponses.
     */
    public function withReplyTo(string $replyTo): self
    {
        $self = clone $this;
        $self['replyTo'] = $replyTo;

        return $self;
    }

    /**
     * Objet personnalisé.
     */
    public function withSubject(string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }

    /**
     * Email du destinataire (défaut = email du client).
     */
    public function withTo(string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }
}
