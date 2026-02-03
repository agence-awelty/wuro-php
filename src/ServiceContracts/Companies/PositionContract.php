<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Companies;

use Wuro\Companies\Position\Position;
use Wuro\Companies\Position\PositionCreateParams\Right;
use Wuro\Companies\Position\PositionUpdateParams\State;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RightShape from \Wuro\Companies\Position\PositionCreateParams\Right
 * @phpstan-import-type RightShape from \Wuro\Companies\Position\PositionUpdateParams\Right as RightShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PositionContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param string $type Type de poste (ID du Type de droits)
     * @param string $user Identifiant de l'utilisateur
     * @param list<Right|RightShape> $rights Liste des droits spécifiques
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $uid,
        string $type,
        string $user,
        ?array $rights = null,
        RequestOptions|array|null $requestOptions = null,
    ): Position;

    /**
     * @api
     *
     * @param string $uid Path param: Identifiant unique du poste
     * @param string $company Path param: Identifiant unique de l'entreprise
     * @param list<\Wuro\Companies\Position\PositionUpdateParams\Right|RightShape1> $rights Body param: Liste des droits spécifiques
     * @param State|value-of<State> $state Body param: État du poste
     * @param string $type Body param: Type de poste (ID du Type de droits)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        string $company,
        ?array $rights = null,
        State|string|null $state = null,
        ?string $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): Position;
}
