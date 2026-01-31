<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Absences\AbsenceCreateParams;
use Wuro\Absences\AbsenceCreateParams\FromMoment;
use Wuro\Absences\AbsenceCreateParams\Log;
use Wuro\Absences\AbsenceCreateParams\State;
use Wuro\Absences\AbsenceCreateParams\ToMoment;
use Wuro\Absences\AbsenceDeleteResponse;
use Wuro\Absences\AbsenceGetResponse;
use Wuro\Absences\AbsenceListParams;
use Wuro\Absences\AbsenceListResponse;
use Wuro\Absences\AbsenceNewResponse;
use Wuro\Absences\AbsenceRetrieveParams;
use Wuro\Absences\AbsenceUpdateParams;
use Wuro\Absences\AbsenceUpdateResponse;
use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\AbsencesRawContract;

/**
 * @phpstan-import-type LogShape from \Wuro\Absences\AbsenceCreateParams\Log
 * @phpstan-import-type LogShape from \Wuro\Absences\AbsenceUpdateParams\Log as LogShape1
 * @phpstan-import-type PositionToShape from \Wuro\Absences\AbsenceListParams\PositionTo
 * @phpstan-import-type TypeShape from \Wuro\Absences\AbsenceListParams\Type
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class AbsencesRawService implements AbsencesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Crée une nouvelle demande d'absence pour un collaborateur.
     *
     * ## Workflow de validation
     *
     * Par défaut, l'absence est créée en état "waiting" (en attente de validation).
     * Le responsable peut ensuite la valider ("accepted") ou la refuser ("rejected").
     *
     * ## Gestion des demi-journées
     *
     * Les absences supportent les demi-journées :
     * - Utilisez `from_moment` et `to_moment` avec les valeurs "full", "half-am" ou "half-pm"
     * - Exemple : absence du lundi après-midi au mercredi matin
     *
     * ## Résolution automatique du collaborateur
     *
     * Si vous fournissez uniquement `positionTo` sans `userTo`,
     * l'API récupère automatiquement l'utilisateur associé au poste.
     *
     * ## Événement déclenché
     *
     * Un événement `CREATE_ABSENCE` est émis après la création,
     * permettant de notifier les responsables de la nouvelle demande.
     *
     * @param array{
     *   from: \DateTimeInterface,
     *   to: \DateTimeInterface,
     *   type: string,
     *   fromMoment?: FromMoment|value-of<FromMoment>,
     *   logs?: list<Log|LogShape>,
     *   positionTo?: string,
     *   state?: State|value-of<State>,
     *   toMoment?: ToMoment|value-of<ToMoment>,
     *   userTo?: string,
     * }|AbsenceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AbsenceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AbsenceCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'absence',
            body: (object) $parsed,
            options: $options,
            convert: AbsenceNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les informations détaillées d'une absence spécifique.
     *
     * Les informations incluent :
     * - Les dates et moments (matin/après-midi/journée entière)
     * - Le type d'absence
     * - L'état actuel (en attente, validée, refusée, etc.)
     * - L'historique complet des actions (logs)
     * - Le collaborateur et son poste concernés
     *
     * @param string $uid Identifiant unique de l'absence
     * @param array{populate?: string}|AbsenceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|AbsenceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AbsenceRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['absence/%1$s', $uid],
            query: $parsed,
            options: $options,
            convert: AbsenceGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Met à jour une absence existante.
     *
     * ## Cas d'utilisation courants
     *
     * - **Validation/Refus** : Changer le state vers "accepted" ou "rejected"
     * - **Modification des dates** : Ajuster la période d'absence
     * - **Annulation** : Passer en state "canceled"
     *
     * ## Système de logs
     *
     * Chaque modification est tracée dans l'historique (logs).
     * Vous pouvez ajouter un commentaire et/ou une pièce jointe à chaque action.
     *
     * Les logs enregistrent automatiquement :
     * - La date de l'action
     * - Le poste ayant effectué l'action
     * - La méthode HTTP utilisée
     * - L'état résultant
     *
     * ## Événement déclenché
     *
     * Un événement `UPDATE_ABSENCE` est émis après la mise à jour,
     * permettant de notifier le collaborateur des changements.
     *
     * @param string $uid Identifiant unique de l'absence
     * @param array{
     *   from?: \DateTimeInterface,
     *   fromMoment?: AbsenceUpdateParams\FromMoment|value-of<AbsenceUpdateParams\FromMoment>,
     *   logs?: list<AbsenceUpdateParams\Log|LogShape1>,
     *   state?: AbsenceUpdateParams\State|value-of<AbsenceUpdateParams\State>,
     *   to?: \DateTimeInterface,
     *   toMoment?: AbsenceUpdateParams\ToMoment|value-of<AbsenceUpdateParams\ToMoment>,
     *   type?: string,
     * }|AbsenceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|AbsenceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AbsenceUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['absence/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: AbsenceUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste des absences de l'entreprise avec de nombreuses options de filtrage.
     *
     * Cette route est particulièrement utile pour :
     * - Afficher le calendrier des absences d'équipe
     * - Filtrer les absences par collaborateur ou période
     * - Obtenir les absences du jour (pour un dashboard RH)
     *
     * ## Filtres de période
     *
     * Plusieurs modes de filtrage temporel sont disponibles :
     *
     * - **month + year** : Absences sur un mois calendaire (avec marge du mois précédent/suivant)
     * - **today** : Absences en cours aujourd'hui (distingue matin/après-midi)
     * - **from / to** : Filtrer par date de début ou fin exacte
     * - **inPeriod** : Absences chevauchant une période donnée
     *
     * ## Gestion des demi-journées
     *
     * Les absences peuvent commencer ou finir en demi-journée :
     * - **full** : Journée entière
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     *
     * @param array{
     *   from?: \DateTimeInterface,
     *   inPeriod?: list<\DateTimeInterface>,
     *   limit?: int,
     *   month?: int,
     *   positionTo?: PositionToShape,
     *   skip?: int,
     *   sort?: string,
     *   state?: AbsenceListParams\State|value-of<AbsenceListParams\State>,
     *   to?: \DateTimeInterface,
     *   today?: bool,
     *   type?: TypeShape,
     *   userTo?: string,
     *   year?: int,
     * }|AbsenceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|AbsenceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AbsenceListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'absences',
            query: $parsed,
            options: $options,
            convert: AbsenceListResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime une absence (soft delete).
     *
     * L'absence n'est pas physiquement supprimée mais passe en état "inactive".
     * Un log de suppression est automatiquement ajouté à l'historique.
     *
     * ## Traçabilité
     *
     * La suppression enregistre :
     * - La date de suppression
     * - Le poste ayant effectué l'action
     * - L'état précédent de l'absence
     *
     * ## Événement déclenché
     *
     * Un événement `DELETE_ABSENCE` est émis, permettant de notifier
     * le collaborateur de l'annulation de sa demande.
     *
     * @param string $uid Identifiant unique de l'absence
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AbsenceDeleteResponse>
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
            path: ['absence/%1$s', $uid],
            options: $requestOptions,
            convert: AbsenceDeleteResponse::class,
        );
    }
}
