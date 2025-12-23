<?php

declare(strict_types=1);

namespace Wuro\Services\Companies;

use Wuro\Client;
use Wuro\Companies\Position\Position;
use Wuro\Companies\Position\PositionUpdateParams\State;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Companies\PositionContract;

final class PositionService implements PositionContract
{
    /**
     * @api
     */
    public PositionRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PositionRawService($client);
    }

    /**
     * @api
     *
     * Crée un nouveau poste (position) pour un utilisateur dans l'entreprise.
     *
     * **Concept de Position:**
     * - Un poste représente le lien entre un utilisateur et une entreprise
     * - Chaque poste définit un type (admin, collaborateur, etc.) et des droits spécifiques
     * - Un utilisateur peut avoir des postes dans plusieurs entreprises
     *
     * **Champs requis:**
     * - `user` : Identifiant de l'utilisateur à ajouter
     * - `type` : Type de poste (référence vers un Type de droits)
     *
     * **Événement déclenché:** CREATE_POSITION
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
    ): Position {
        $params = Util::removeNulls(
            ['type' => $type, 'user' => $user, 'rights' => $rights]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour un poste (position) existant dans une entreprise.
     *
     * **Modifications possibles:**
     * - Changer le type de poste
     * - Modifier les droits spécifiques
     * - Activer/désactiver le poste
     *
     * **États du poste:**
     * - `active` : Poste actif, l'utilisateur a accès à l'entreprise
     * - `inactive` : Poste désactivé, accès révoqué
     *
     * **Événement déclenché:** UPDATE_POSITION
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
    ): Position {
        $params = Util::removeNulls(
            [
                'company' => $company,
                'rights' => $rights,
                'state' => $state,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
