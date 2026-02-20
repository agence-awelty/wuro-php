<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Companies;

use Wuro\Companies\AppInfos\CompanyApp;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface AppInfosContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): CompanyApp;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): CompanyApp;
}
