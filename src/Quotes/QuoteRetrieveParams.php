<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les détails complets d'un devis spécifique.
 *
 * **Réponse enrichie:**
 * - Inclut les liens `pdf_link` et `html_link` pour accéder aux documents
 *
 * @see Wuro\Services\QuotesService::retrieve()
 *
 * @phpstan-type QuoteRetrieveParamsShape = array{populate?: string|null}
 */
final class QuoteRetrieveParams implements BaseModel
{
    /** @use SdkModel<QuoteRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Champs à peupler (ex. "client,documentModel").
     */
    #[Optional]
    public ?string $populate;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $populate = null): self
    {
        $self = new self;

        null !== $populate && $self['populate'] = $populate;

        return $self;
    }

    /**
     * Champs à peupler (ex. "client,documentModel").
     */
    public function withPopulate(string $populate): self
    {
        $self = clone $this;
        $self['populate'] = $populate;

        return $self;
    }
}
