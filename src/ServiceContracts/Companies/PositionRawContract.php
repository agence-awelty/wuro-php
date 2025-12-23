<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Companies;

use Wuro\Companies\Position\Position;
use Wuro\Companies\Position\PositionCreateParams;
use Wuro\Companies\Position\PositionUpdateParams;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface PositionRawContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param array<string,mixed>|PositionCreateParams $params
     *
     * @return BaseResponse<Position>
     *
     * @throws APIException
     */
    public function create(
        string $uid,
        array|PositionCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Path param: Identifiant unique du poste
     * @param array<string,mixed>|PositionUpdateParams $params
     *
     * @return BaseResponse<Position>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PositionUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
