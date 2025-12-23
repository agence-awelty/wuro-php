<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\InvoiceFile\InvoiceFileAnalyzeResponse;
use Wuro\RequestOptions;

interface InvoiceFileContract
{
    /**
     * @api
     *
     * @param string $file Fichier PDF encodé en base64
     *
     * @throws APIException
     */
    public function analyze(
        string $file,
        ?RequestOptions $requestOptions = null
    ): InvoiceFileAnalyzeResponse;
}
