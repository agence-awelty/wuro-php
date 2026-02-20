<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Absences\AbsenceCreateParams\FromMoment;
use Wuro\Absences\AbsenceCreateParams\Log;
use Wuro\Absences\AbsenceCreateParams\State;
use Wuro\Absences\AbsenceCreateParams\ToMoment;
use Wuro\Absences\AbsenceDeleteResponse;
use Wuro\Absences\AbsenceGetResponse;
use Wuro\Absences\AbsenceListResponse;
use Wuro\Absences\AbsenceNewResponse;
use Wuro\Absences\AbsenceUpdateResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type LogShape from \Wuro\Absences\AbsenceCreateParams\Log
 * @phpstan-import-type LogShape from \Wuro\Absences\AbsenceUpdateParams\Log as LogShape1
 * @phpstan-import-type PositionToShape from \Wuro\Absences\AbsenceListParams\PositionTo
 * @phpstan-import-type TypeShape from \Wuro\Absences\AbsenceListParams\Type
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface AbsencesContract
{
    /**
     * @api
     *
     * @param \DateTimeInterface $from Date de début de l'absence (obligatoire)
     * @param \DateTimeInterface $to Date de fin de l'absence (obligatoire)
     * @param string $type Référence vers le type d'absence (obligatoire)
     * @param FromMoment|value-of<FromMoment> $fromMoment Moment de début :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param list<Log|LogShape> $logs Historique initial (généralement vide à la création)
     * @param string $positionTo Poste concerné par l'absence.
     * Si fourni sans userTo, l'utilisateur est résolu automatiquement.
     * @param State|value-of<State> $state État initial de l'absence (waiting par défaut)
     * @param ToMoment|value-of<ToMoment> $toMoment Moment de fin :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param string $userTo Utilisateur concerné par l'absence.
     * Optionnel si positionTo est fourni (résolu automatiquement).
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        \DateTimeInterface $from,
        \DateTimeInterface $to,
        string $type,
        FromMoment|string $fromMoment = 'full',
        ?array $logs = null,
        ?string $positionTo = null,
        State|string $state = 'waiting',
        ToMoment|string $toMoment = 'full',
        ?string $userTo = null,
        RequestOptions|array|null $requestOptions = null,
    ): AbsenceNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param string $populate Relations à inclure (ex. "type", "positionTo", "userTo")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): AbsenceGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param \DateTimeInterface $from Date de début de l'absence
     * @param \Wuro\Absences\AbsenceUpdateParams\FromMoment|value-of<\Wuro\Absences\AbsenceUpdateParams\FromMoment> $fromMoment Moment de début :
     * - **full** : Journée entière
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param list<\Wuro\Absences\AbsenceUpdateParams\Log|LogShape1> $logs Ajouter des entrées à l'historique de l'absence
     * @param \Wuro\Absences\AbsenceUpdateParams\State|value-of<\Wuro\Absences\AbsenceUpdateParams\State> $state Nouvel état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée par le responsable
     * - **rejected** : Refusée par le responsable
     * - **canceled** : Annulée par le collaborateur
     * @param \DateTimeInterface $to Date de fin de l'absence
     * @param \Wuro\Absences\AbsenceUpdateParams\ToMoment|value-of<\Wuro\Absences\AbsenceUpdateParams\ToMoment> $toMoment Moment de fin :
     * - **full** : Journée entière
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param string $type Référence vers le type d'absence
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?\DateTimeInterface $from = null,
        \Wuro\Absences\AbsenceUpdateParams\FromMoment|string|null $fromMoment = null,
        ?array $logs = null,
        \Wuro\Absences\AbsenceUpdateParams\State|string|null $state = null,
        ?\DateTimeInterface $to = null,
        \Wuro\Absences\AbsenceUpdateParams\ToMoment|string|null $toMoment = null,
        ?string $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): AbsenceUpdateResponse;

    /**
     * @api
     *
     * @param \DateTimeInterface $from Filtrer par date de début (format ISO)
     * @param list<\DateTimeInterface> $inPeriod Tableau de 2 dates [début, fin] pour obtenir les absences chevauchant cette période.
     * Utile pour le calendrier : récupère les absences qui commencent, finissent ou traversent la période.
     * @param int $limit Nombre maximum d'absences à retourner
     * @param int $month Mois pour le filtre calendrier (1-12). Requiert year.
     * @param PositionToShape $positionTo Filtrer par poste concerné. Valeurs spéciales :
     * - **all** : Tous les postes
     * - **onlyActive** : Postes actifs uniquement
     * - ID de poste pour un poste spécifique
     * - Tableau d'IDs pour plusieurs postes
     * @param int $skip Nombre d'absences à ignorer (pagination)
     * @param string $sort Tri des résultats (ex. "from:-1" pour les plus récentes d'abord)
     * @param \Wuro\Absences\AbsenceListParams\State|value-of<\Wuro\Absences\AbsenceListParams\State> $state Filtrer par état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée
     * - **rejected** : Refusée
     * - **canceled** : Annulée par le collaborateur
     * - **inactive** : Supprimée (soft delete)
     * @param \DateTimeInterface $to Filtrer par date de fin (format ISO)
     * @param bool $today Si true, retourne uniquement les absences du jour en cours
     * @param TypeShape $type Filtrer par type d'absence (peut être un tableau)
     * @param string $userTo Filtrer par utilisateur concerné
     * @param int $year Année pour le filtre calendrier. Requiert month.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?\DateTimeInterface $from = null,
        ?array $inPeriod = null,
        int $limit = 20,
        ?int $month = null,
        string|array|null $positionTo = null,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\Absences\AbsenceListParams\State|string|null $state = null,
        ?\DateTimeInterface $to = null,
        ?bool $today = null,
        string|array|null $type = null,
        ?string $userTo = null,
        ?int $year = null,
        RequestOptions|array|null $requestOptions = null,
    ): AbsenceListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): AbsenceDeleteResponse;
}
