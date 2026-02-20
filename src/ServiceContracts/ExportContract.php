<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Export\ExportExportAbsencesResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ExportContract
{
    /**
     * @api
     *
     * @param string $company Reference to the company
     * @param mixed $filters Filters to apply to the export
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function exportAbsences(
        ?string $company = null,
        mixed $filters = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExportExportAbsencesResponse;
}
