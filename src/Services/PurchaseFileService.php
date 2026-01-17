<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\PurchaseFile\PurchaseFileAnalyzeResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PurchaseFileContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class PurchaseFileService implements PurchaseFileContract
{
    /**
     * @api
     */
    public PurchaseFileRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PurchaseFileRawService($client);
    }

    /**
     * @api
     *
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
     * @param string $file Fichier PDF encodé en base64
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function analyze(
        ?string $file = null,
        RequestOptions|array|null $requestOptions = null
    ): PurchaseFileAnalyzeResponse {
        $params = Util::removeNulls(['file' => $file]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->analyze(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
