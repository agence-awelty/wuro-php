<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Companies;

use Wuro\Companies\AppInfos\CompanyApp;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface AppInfosRawContract
{
    /**
     * @api
     *
     * @return BaseResponse<CompanyApp>
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @return BaseResponse<CompanyApp>
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
