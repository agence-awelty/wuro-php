<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\Statistics\StatisticGetPaymentsResponse;

interface StatisticsRawContract
{
    /**
     * @api
     *
     * @return BaseResponse<StatisticGetPaymentsResponse>
     *
     * @throws APIException
     */
    public function retrievePayments(
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
