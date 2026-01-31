<?php

declare(strict_types=1);

namespace Wuro\Services\Companies;

use Wuro\Client;
use Wuro\Companies\Position\Position;
use Wuro\Companies\Position\PositionCreateParams;
use Wuro\Companies\Position\PositionCreateParams\Right;
use Wuro\Companies\Position\PositionUpdateParams;
use Wuro\Companies\Position\PositionUpdateParams\State;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Companies\PositionRawContract;

/**
 * @phpstan-import-type RightShape from \Wuro\Companies\Position\PositionCreateParams\Right
 * @phpstan-import-type RightShape from \Wuro\Companies\Position\PositionUpdateParams\Right as RightShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class PositionRawService implements PositionRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   type: string, user: string, rights?: list<Right|RightShape>
     * }|PositionCreateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = PositionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['company/%1$s/position', $uid],
            body: (object) $parsed,
            options: $options,
            convert: Position::class,
        );
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
     * @param array{
     *   company: string,
     *   rights?: list<PositionUpdateParams\Right|RightShape1>,
     *   state?: State|value-of<State>,
     *   type?: string,
     * }|PositionUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = PositionUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $company = $parsed['company'];
        unset($parsed['company']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['company/%1$s/position/%2$s', $company, $uid],
            body: (object) array_diff_key($parsed, array_flip(['company'])),
            options: $options,
            convert: Position::class,
        );
    }
}
