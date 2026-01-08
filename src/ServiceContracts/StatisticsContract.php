<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\Statistics\StatisticGetPaymentsResponse;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface StatisticsContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrievePayments(
        RequestOptions|array|null $requestOptions = null
    ): StatisticGetPaymentsResponse;
}
