<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Export\ExportExportAbsencesParams;
use Wuro\Export\ExportExportAbsencesResponse;
use Wuro\RequestOptions;

interface ExportRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ExportExportAbsencesParams $params
     *
     * @return BaseResponse<ExportExportAbsencesResponse>
     *
     * @throws APIException
     */
    public function exportAbsences(
        array|ExportExportAbsencesParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
