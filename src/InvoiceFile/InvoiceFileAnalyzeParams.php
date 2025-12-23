<?php

declare(strict_types=1);

namespace Wuro\InvoiceFile;

use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Analyse un fichier PDF de facture via OCR et IA (Mistral) pour en extraire les informations.
 *
 * **Utilisation:**
 * - Envoyer le fichier PDF en base64 dans le champ `file`
 * - L'IA extrait: fournisseur, date, numéro, lignes, totaux, TVA
 *
 * **Restrictions:**
 * - La reconnaissance doit être activée pour l'entreprise (`visionAnalytic`)
 *
 * **Réponse:**
 * - `invoice`: Données extraites du PDF
 * - `preSubmitInvoice`: Données avec totaux recalculés (pour vérification)
 *
 * @see Wuro\Services\InvoiceFileService::analyze()
 *
 * @phpstan-type InvoiceFileAnalyzeParamsShape = array{file: string}
 */
final class InvoiceFileAnalyzeParams implements BaseModel
{
    /** @use SdkModel<InvoiceFileAnalyzeParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Fichier PDF encodé en base64.
     */
    #[Required]
    public string $file;

    /**
     * `new InvoiceFileAnalyzeParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InvoiceFileAnalyzeParams::with(file: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InvoiceFileAnalyzeParams)->withFile(...)
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
     */
    public static function with(string $file): self
    {
        $self = new self;

        $self['file'] = $file;

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
