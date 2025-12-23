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

interface UsersRawContract
{
    /**
     * @api
     *
     * @return BaseResponse<UserGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserUpdateParams $params
     *
     * @return BaseResponse<UserUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|UserUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function deactivate(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     *
     * @return BaseResponse<UserListInvitationsResponse>
     *
     * @throws APIException
     */
    public function listInvitations(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     *
     * @return BaseResponse<UserListNotificationsResponse>
     *
     * @throws APIException
     */
    public function listNotifications(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'utilisateur
     *
     * @return BaseResponse<UserListPositionsResponse>
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $uid ID MongoDB ou adresse email de l'utilisateur
     *
     * @return BaseResponse<UserGetByUidResponse>
     *
     * @throws APIException
     */
    public function retrieveByUid(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
