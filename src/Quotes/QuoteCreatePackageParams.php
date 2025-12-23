<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Génère une archive ZIP contenant les PDFs de plusieurs devis.
 *
 * **Comportement:**
 * - Si le nombre de devis > seuil configuré ou `DEFERRED=true`, l'archive est générée en arrière-plan
 * - Un objet Package est créé pour suivre la progression
 * - Une fois terminé, l'archive est téléchargeable via GET /package/{uid}/download
 *
 * @see Wuro\Services\QuotesService::createPackage()
 *
 * @phpstan-type QuoteCreatePackageParamsShape = array{
 *   quotesID: list<string>, deferred?: bool|null
 * }
 */
final class QuoteCreatePackageParams implements BaseModel
{
    /** @use SdkModel<QuoteCreatePackageParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Liste des IDs de devis à inclure.
     *
     * @var list<string> $quotesID
     */
    #[Required('quotesId', list: 'string')]
    public array $quotesID;

    /**
     * Forcer le mode différé.
     */
    #[Optional('DEFERRED')]
    public ?bool $deferred;

    /**
     * `new QuoteCreatePackageParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * QuoteCreatePackageParams::with(quotesID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new QuoteCreatePackageParams)->withQuotesID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string> $quotesID
     */
    public static function with(array $quotesID, ?bool $deferred = null): self
    {
        $self = new self;

        $self['quotesID'] = $quotesID;

        null !== $deferred && $self['deferred'] = $deferred;

        return $self;
    }

    /**
     * Liste des IDs de devis à inclure.
     *
     * @param list<string> $quotesID
     */
    public function withQuotesID(array $quotesID): self
    {
        $self = clone $this;
        $self['quotesID'] = $quotesID;

        return $self;
    }

    /**
     * Forcer le mode différé.
     */
    public function withDeferred(bool $deferred): self
    {
        $self = clone $this;
        $self['deferred'] = $deferred;

        return $self;
    }
}
