<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\ProductUnits\ProductUnitListResponseItem;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ProductUnitsContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return list<ProductUnitListResponseItem>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): array;
}
