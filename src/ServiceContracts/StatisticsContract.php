<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\Statistics\StatisticGetPaymentsResponse;

interface StatisticsContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function retrievePayments(
        ?RequestOptions $requestOptions = null
    ): StatisticGetPaymentsResponse;
}
