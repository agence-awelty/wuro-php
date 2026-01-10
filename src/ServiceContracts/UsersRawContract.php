<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\Users\UserGetByUidResponse;
use Wuro\Users\UserGetResponse;
use Wuro\Users\UserListInvitationsResponse;
use Wuro\Users\UserListNotificationsResponse;
use Wuro\Users\UserListPositionsResponse;
use Wuro\Users\UserUpdateParams;
use Wuro\Users\UserUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface UsersRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|UserUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function deactivate(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListInvitationsResponse>
     *
     * @throws APIException
     */
    public function listInvitations(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListNotificationsResponse>
     *
     * @throws APIException
     */
    public function listNotifications(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListPositionsResponse>
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID MongoDB ou adresse email de l'utilisateur
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetByUidResponse>
     *
     * @throws APIException
     */
    public function retrieveByUid(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
