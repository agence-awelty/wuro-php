<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Export\ExportExportAbsencesParams;
use Wuro\Export\ExportExportAbsencesResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ExportRawContract;

final class ExportRawService implements ExportRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Export absences
     *
     * @param array{
     *   company?: string, filters?: mixed
     * }|ExportExportAbsencesParams $params
     *
     * @return BaseResponse<ExportExportAbsencesResponse>
     *
     * @throws APIException
     */
    public function exportAbsences(
        array|ExportExportAbsencesParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExportExportAbsencesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'export/absences',
            body: (object) $parsed,
            options: $options,
            convert: ExportExportAbsencesResponse::class,
        );
    }
}
