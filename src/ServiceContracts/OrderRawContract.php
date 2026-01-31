<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface OrderRawContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique de la commande
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrievePaymentInfos(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
