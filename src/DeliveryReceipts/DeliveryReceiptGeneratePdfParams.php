<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Génère et retourne le PDF du bon de livraison.
 *
 * Le PDF est généré à partir du modèle de document configuré pour l'entreprise
 * et inclut toutes les informations du bon : client, lignes, dates, etc.
 *
 * ## Paramètres de téléchargement
 *
 * - Par défaut, le PDF s'affiche dans le navigateur (inline)
 * - Utilisez `force_download=true` pour forcer le téléchargement
 *
 * ## Format de sortie
 *
 * - Content-Type: application/pdf
 * - Content-Disposition: filename={numero_bon}.pdf
 *
 * @see Wuro\Services\DeliveryReceiptsService::generatePdf()
 *
 * @phpstan-type DeliveryReceiptGeneratePdfParamsShape = array{
 *   forceDownload?: bool|null
 * }
 */
final class DeliveryReceiptGeneratePdfParams implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptGeneratePdfParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Si true, force le téléchargement du fichier au lieu de l'afficher.
     */
    #[Optional]
    public ?bool $forceDownload;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $forceDownload = null): self
    {
        $self = new self;

        null !== $forceDownload && $self['forceDownload'] = $forceDownload;

        return $self;
    }

    /**
     * Si true, force le téléchargement du fichier au lieu de l'afficher.
     */
    public function withForceDownload(bool $forceDownload): self
    {
        $self = clone $this;
        $self['forceDownload'] = $forceDownload;

        return $self;
    }
}
