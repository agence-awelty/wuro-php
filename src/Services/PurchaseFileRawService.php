<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\PurchaseFile\PurchaseFileAnalyzeParams;
use Wuro\PurchaseFile\PurchaseFileAnalyzeResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PurchaseFileRawContract;

final class PurchaseFileRawService implements PurchaseFileRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{file?: string}|PurchaseFileAnalyzeParams $params
     *
     * @return BaseResponse<PurchaseFileAnalyzeResponse>
     *
     * @throws APIException
     */
    public function analyze(
        array|PurchaseFileAnalyzeParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PurchaseFileAnalyzeParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'purchase-file',
            body: (object) $parsed,
            options: $options,
            convert: PurchaseFileAnalyzeResponse::class,
        );
    }
}
