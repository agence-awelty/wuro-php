<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface OrderContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique de la commande
     *
     * @throws APIException
     */
    public function retrievePaymentInfos(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;
}
