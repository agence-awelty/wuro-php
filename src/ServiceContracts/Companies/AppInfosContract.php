<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Companies;

use Wuro\Companies\AppInfos\CompanyApp;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface AppInfosContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): CompanyApp;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyApp;
}
