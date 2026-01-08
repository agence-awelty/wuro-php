<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Companies;

use Wuro\Companies\Position\Position;
use Wuro\Companies\Position\PositionCreateParams;
use Wuro\Companies\Position\PositionUpdateParams;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PositionRawContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param array<string,mixed>|PositionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Position>
     *
     * @throws APIException
     */
    public function create(
        string $uid,
        array|PositionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Path param: Identifiant unique du poste
     * @param array<string,mixed>|PositionUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Position>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PositionUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
