<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Companies;

use Wuro\Companies\Position\Position;
use Wuro\Companies\Position\PositionUpdateParams\State;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface PositionContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     * @param string $type Type de poste (ID du Type de droits)
     * @param string $user Identifiant de l'utilisateur
     * @param list<array{
     *   checked?: bool, group?: string, name?: string
     * }> $rights Liste des droits spécifiques
     *
     * @throws APIException
     */
    public function create(
        string $uid,
        string $type,
        string $user,
        ?array $rights = null,
        ?RequestOptions $requestOptions = null,
    ): Position;

    /**
     * @api
     *
     * @param string $uid Path param: Identifiant unique du poste
     * @param string $company Path param: Identifiant unique de l'entreprise
     * @param list<array{
     *   checked?: bool, group?: string, name?: string
     * }> $rights Body param: Liste des droits spécifiques
     * @param 'active'|'inactive'|State $state Body param: État du poste
     * @param string $type Body param: Type de poste (ID du Type de droits)
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        string $company,
        ?array $rights = null,
        string|State|null $state = null,
        ?string $type = null,
        ?RequestOptions $requestOptions = null,
    ): Position;
}
