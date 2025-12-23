<?php

declare(strict_types=1);

namespace Wuro\PurchaseFile;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Analyse un fichier PDF de facture fournisseur via OCR et IA pour en extraire les informations.
 *
 * **Utilisation:**
 * - Envoyer le fichier PDF en base64 dans le corps de la requête
 * - L'IA extrait : fournisseur, date, numéro, lignes, totaux, TVA
 *
 * **Restrictions:**
 * - La reconnaissance doit être activée pour l'entreprise (`visionAnalytic`)
 *
 * **Réponse:**
 * - `purchase` : Données extraites du PDF
 * - `preSubmitPurchase` : Données avec totaux recalculés (pour vérification)
 *
 * @see Wuro\Services\PurchaseFileService::analyze()
 *
 * @phpstan-type PurchaseFileAnalyzeParamsShape = array{file?: string|null}
 */
final class PurchaseFileAnalyzeParams implements BaseModel
{
    /** @use SdkModel<PurchaseFileAnalyzeParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Fichier PDF encodé en base64.
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
    public static function with(?string $file = null): self
    {
        $self = new self;

        null !== $file && $self['file'] = $file;

        return $self;
    }

    /**
     * Fichier PDF encodé en base64.
     */
    public function withFile(string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }
}
