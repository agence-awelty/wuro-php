<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\AbsenceTypes\AbsenceTypeCreateParams;
use Wuro\AbsenceTypes\AbsenceTypeCreateParams\State;
use Wuro\AbsenceTypes\AbsenceTypeCreateParams\Type;
use Wuro\AbsenceTypes\AbsenceTypeDeleteResponse;
use Wuro\AbsenceTypes\AbsenceTypeGetResponse;
use Wuro\AbsenceTypes\AbsenceTypeListParams;
use Wuro\AbsenceTypes\AbsenceTypeListResponse;
use Wuro\AbsenceTypes\AbsenceTypeNewResponse;
use Wuro\AbsenceTypes\AbsenceTypeUpdateParams;
use Wuro\AbsenceTypes\AbsenceTypeUpdateResponse;
use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\AbsenceTypesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class AbsenceTypesRawService implements AbsenceTypesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Crée un nouveau type d'absence pour l'entreprise.
     *
     * Les types d'absence permettent de catégoriser les demandes d'absence des collaborateurs.
     * Exemples de types courants :
     * - Congés payés
     * - RTT
     * - Congé maladie
     * - Télétravail
     * - Formation
     * - Événement client
     *
     * Vous pouvez personnaliser l'apparence de chaque type avec une icône et des couleurs
     * pour faciliter la lecture du calendrier d'équipe.
     *
     * @param array{
     *   name: string,
     *   backgroundColor?: string,
     *   backgroundColorRgb?: string,
     *   color?: string,
     *   icon?: string,
     *   state?: State|value-of<State>,
     *   type?: Type|value-of<Type>,
     * }|AbsenceTypeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AbsenceTypeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AbsenceTypeCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'absence-type',
            body: (object) $parsed,
            options: $options,
            convert: AbsenceTypeNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les informations détaillées d'un type d'absence spécifique par son identifiant.
     *
     * Les informations incluent le nom, l'icône, les couleurs d'affichage et la catégorie (absence ou event).
     *
     * @param string $uid Identifiant unique du type d'absence
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['absence-type/%1$s', $uid],
            options: $requestOptions,
            convert: AbsenceTypeGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Met à jour les informations d'un type d'absence existant.
     *
     * Vous pouvez modifier :
     * - Le nom affiché
     * - L'icône représentative
     * - Les couleurs (fond et texte) pour la visualisation calendrier
     * - L'état (active/inactive) pour masquer sans supprimer
     *
     * **Note** : Désactiver un type n'affecte pas les absences déjà créées avec ce type.
     *
     * @param string $uid Identifiant unique du type d'absence
     * @param array{
     *   backgroundColor?: string,
     *   backgroundColorRgb?: string,
     *   color?: string,
     *   icon?: string,
     *   name?: string,
     *   state?: AbsenceTypeUpdateParams\State|value-of<AbsenceTypeUpdateParams\State>,
     * }|AbsenceTypeUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|AbsenceTypeUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AbsenceTypeUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['absence-type/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: AbsenceTypeUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste de tous les types d'absence configurés pour l'entreprise.
     *
     * Les types d'absence permettent de catégoriser les absences (congés payés, RTT, maladie, télétravail, etc.).
     * Chaque type peut avoir une icône et des couleurs personnalisées pour une meilleure visualisation dans le calendrier.
     *
     * Les types peuvent être de deux catégories :
     * - **absence** : Congés, RTT, maladie, etc.
     * - **event** : Événements comme les formations, réunions, etc.
     *
     * @param array{
     *   limit?: int,
     *   skip?: int,
     *   sort?: string,
     *   state?: AbsenceTypeListParams\State|value-of<AbsenceTypeListParams\State>,
     *   type?: AbsenceTypeListParams\Type|value-of<AbsenceTypeListParams\Type>,
     * }|AbsenceTypeListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|AbsenceTypeListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AbsenceTypeListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'absence-types',
            query: $parsed,
            options: $options,
            convert: AbsenceTypeListResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime un type d'absence.
     *
     * **Attention** : Cette action est définitive. Pour masquer un type sans le supprimer,
     * utilisez plutôt PATCH avec `state: "inactive"`.
     *
     * La suppression peut échouer si des absences sont liées à ce type.
     *
     * @param string $uid Identifiant unique du type d'absence
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceTypeDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['absence-type/%1$s', $uid],
            options: $requestOptions,
            convert: AbsenceTypeDeleteResponse::class,
        );
    }
}
