<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\InvoiceFile\InvoiceFileAnalyzeResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\InvoiceFileContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class InvoiceFileService implements InvoiceFileContract
{
    /**
     * @api
     */
    public InvoiceFileRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new InvoiceFileRawService($client);
    }

    /**
     * @api
     *
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
     * @param string $file Fichier PDF encodé en base64
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function analyze(
        string $file,
        RequestOptions|array|null $requestOptions = null
    ): InvoiceFileAnalyzeResponse {
        $params = Util::removeNulls(['file' => $file]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->analyze(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
