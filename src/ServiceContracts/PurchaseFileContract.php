<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\PurchaseFile\PurchaseFileAnalyzeResponse;
use Wuro\RequestOptions;

interface PurchaseFileContract
{
    /**
     * @api
     *
     * @param string $file Fichier PDF encodé en base64
     *
     * @throws APIException
     */
    public function analyze(
        ?string $file = null,
        ?RequestOptions $requestOptions = null
    ): PurchaseFileAnalyzeResponse;
}
