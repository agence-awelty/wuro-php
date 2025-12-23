<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\Export\ExportExportAbsencesResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ExportContract;

final class ExportService implements ExportContract
{
    /**
     * @api
     */
    public ExportRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ExportRawService($client);
    }

    /**
     * @api
     *
     * Export absences
     *
     * @param string $company Reference to the company
     * @param mixed $filters Filters to apply to the export
     *
     * @throws APIException
     */
    public function exportAbsences(
        ?string $company = null,
        mixed $filters = null,
        ?RequestOptions $requestOptions = null,
    ): ExportExportAbsencesResponse {
        $params = Util::removeNulls(['company' => $company, 'filters' => $filters]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->exportAbsences(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
