<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Quotes;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Quotes\Line\LineAddParams;
use Wuro\Quotes\Line\LineAddResponse;
use Wuro\Quotes\Line\LineDeleteParams;
use Wuro\Quotes\Line\LineUpdateParams;
use Wuro\Quotes\Line\LineUpdateResponse;
use Wuro\Quotes\Line\Quote;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface LineRawContract
{
    /**
     * @api
     *
     * @param string $lineUuid Path param: Identifiant unique de la ligne à modifier
     * @param array<string,mixed>|LineUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LineUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $lineUuid,
        array|LineUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $lineUuid Identifiant unique de la ligne à supprimer
     * @param array<string,mixed>|LineDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Quote>
     *
     * @throws APIException
     */
    public function delete(
        string $lineUuid,
        array|LineDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param array<string,mixed>|LineAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LineAddResponse>
     *
     * @throws APIException
     */
    public function add(
        string $uid,
        array|LineAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
