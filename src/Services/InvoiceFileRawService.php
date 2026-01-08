<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\InvoiceFile\InvoiceFileAnalyzeParams;
use Wuro\InvoiceFile\InvoiceFileAnalyzeResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\InvoiceFileRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class InvoiceFileRawService implements InvoiceFileRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{file: string}|InvoiceFileAnalyzeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvoiceFileAnalyzeResponse>
     *
     * @throws APIException
     */
    public function analyze(
        array|InvoiceFileAnalyzeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceFileAnalyzeParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'invoice-file',
            body: (object) $parsed,
            options: $options,
            convert: InvoiceFileAnalyzeResponse::class,
        );
    }
}
