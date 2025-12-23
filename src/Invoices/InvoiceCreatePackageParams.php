<?php

declare(strict_types=1);

namespace Wuro\Invoices;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Génère une archive ZIP contenant les PDFs de plusieurs factures.
 *
 * **Comportement:**
 * - Si le nombre de factures > seuil configuré ou `DEFERRED=true`, l'archive est générée en arrière-plan
 * - Un objet Package est créé pour suivre la progression
 * - Une fois terminé, l'archive est téléchargeable via GET /package/{uid}/download
 *
 * **Mode différé:**
 * - Retourne immédiatement avec `newPackage` et un message
 * - Le package passe par les états: created → finished (ou error)
 *
 * @see Wuro\Services\InvoicesService::createPackage()
 *
 * @phpstan-type InvoiceCreatePackageParamsShape = array{
 *   invoicesID: list<string>, deferred?: bool|null
 * }
 */
final class InvoiceCreatePackageParams implements BaseModel
{
    /** @use SdkModel<InvoiceCreatePackageParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Liste des IDs de factures à inclure.
     *
     * @var list<string> $invoicesID
     */
    #[Required('invoicesId', list: 'string')]
    public array $invoicesID;

    /**
     * Forcer le mode différé (génération en arrière-plan).
     */
    #[Optional('DEFERRED')]
    public ?bool $deferred;

    /**
     * `new InvoiceCreatePackageParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InvoiceCreatePackageParams::with(invoicesID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InvoiceCreatePackageParams)->withInvoicesID(...)
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
     * @param list<string> $invoicesID
     */
    public static function with(array $invoicesID, ?bool $deferred = null): self
    {
        $self = new self;

        $self['invoicesID'] = $invoicesID;

        null !== $deferred && $self['deferred'] = $deferred;

        return $self;
    }

    /**
     * Liste des IDs de factures à inclure.
     *
     * @param list<string> $invoicesID
     */
    public function withInvoicesID(array $invoicesID): self
    {
        $self = clone $this;
        $self['invoicesID'] = $invoicesID;

        return $self;
    }

    /**
     * Forcer le mode différé (génération en arrière-plan).
     */
    public function withDeferred(bool $deferred): self
    {
        $self = clone $this;
        $self['deferred'] = $deferred;

        return $self;
    }
}
