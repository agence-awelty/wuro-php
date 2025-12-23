<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Absences\AbsenceCreateParams\FromMoment;
use Wuro\Absences\AbsenceCreateParams\State;
use Wuro\Absences\AbsenceCreateParams\ToMoment;
use Wuro\Absences\AbsenceDeleteResponse;
use Wuro\Absences\AbsenceGetResponse;
use Wuro\Absences\AbsenceListResponse;
use Wuro\Absences\AbsenceNewResponse;
use Wuro\Absences\AbsenceUpdateResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface AbsencesContract
{
    /**
     * @api
     *
     * @param string|\DateTimeInterface $from Date de début de l'absence (obligatoire)
     * @param string|\DateTimeInterface $to Date de fin de l'absence (obligatoire)
     * @param string $type Référence vers le type d'absence (obligatoire)
     * @param 'half-am'|'half-pm'|'full'|FromMoment $fromMoment Moment de début :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param list<array{
     *   comment?: string, file?: string
     * }> $logs Historique initial (généralement vide à la création)
     * @param string $positionTo Poste concerné par l'absence.
     * Si fourni sans userTo, l'utilisateur est résolu automatiquement.
     * @param 'waiting'|'accepted'|'rejected'|'canceled'|State $state État initial de l'absence (waiting par défaut)
     * @param 'half-am'|'half-pm'|'full'|ToMoment $toMoment Moment de fin :
     * - **full** : Journée entière (défaut)
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param string $userTo Utilisateur concerné par l'absence.
     * Optionnel si positionTo est fourni (résolu automatiquement).
     *
     * @throws APIException
     */
    public function create(
        string|\DateTimeInterface $from,
        string|\DateTimeInterface $to,
        string $type,
        string|FromMoment $fromMoment = 'full',
        ?array $logs = null,
        ?string $positionTo = null,
        string|State $state = 'waiting',
        string|ToMoment $toMoment = 'full',
        ?string $userTo = null,
        ?RequestOptions $requestOptions = null,
    ): AbsenceNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param string $populate Relations à inclure (ex. "type", "positionTo", "userTo")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null,
    ): AbsenceGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     * @param string|\DateTimeInterface $from Date de début de l'absence
     * @param 'half-am'|'half-pm'|'full'|\Wuro\Absences\AbsenceUpdateParams\FromMoment $fromMoment Moment de début :
     * - **full** : Journée entière
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param list<array{
     *   comment?: string,
     *   date?: string|\DateTimeInterface,
     *   file?: string,
     *   method?: string,
     *   position?: string,
     *   state?: string,
     * }> $logs Ajouter des entrées à l'historique de l'absence
     * @param 'waiting'|'accepted'|'rejected'|'canceled'|'inactive'|\Wuro\Absences\AbsenceUpdateParams\State $state Nouvel état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée par le responsable
     * - **rejected** : Refusée par le responsable
     * - **canceled** : Annulée par le collaborateur
     * @param string|\DateTimeInterface $to Date de fin de l'absence
     * @param 'half-am'|'half-pm'|'full'|\Wuro\Absences\AbsenceUpdateParams\ToMoment $toMoment Moment de fin :
     * - **full** : Journée entière
     * - **half-am** : Matin uniquement
     * - **half-pm** : Après-midi uniquement
     * @param string $type Référence vers le type d'absence
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        string|\DateTimeInterface|null $from = null,
        string|\Wuro\Absences\AbsenceUpdateParams\FromMoment|null $fromMoment = null,
        ?array $logs = null,
        string|\Wuro\Absences\AbsenceUpdateParams\State|null $state = null,
        string|\DateTimeInterface|null $to = null,
        string|\Wuro\Absences\AbsenceUpdateParams\ToMoment|null $toMoment = null,
        ?string $type = null,
        ?RequestOptions $requestOptions = null,
    ): AbsenceUpdateResponse;

    /**
     * @api
     *
     * @param string|\DateTimeInterface $from Filtrer par date de début (format ISO)
     * @param list<string|\DateTimeInterface> $inPeriod Tableau de 2 dates [début, fin] pour obtenir les absences chevauchant cette période.
     * Utile pour le calendrier : récupère les absences qui commencent, finissent ou traversent la période.
     * @param int $limit Nombre maximum d'absences à retourner
     * @param int $month Mois pour le filtre calendrier (1-12). Requiert year.
     * @param string|list<string> $positionTo Filtrer par poste concerné. Valeurs spéciales :
     * - **all** : Tous les postes
     * - **onlyActive** : Postes actifs uniquement
     * - ID de poste pour un poste spécifique
     * - Tableau d'IDs pour plusieurs postes
     * @param int $skip Nombre d'absences à ignorer (pagination)
     * @param string $sort Tri des résultats (ex. "from:-1" pour les plus récentes d'abord)
     * @param 'waiting'|'accepted'|'rejected'|'canceled'|'inactive'|\Wuro\Absences\AbsenceListParams\State $state Filtrer par état de l'absence :
     * - **waiting** : En attente de validation
     * - **accepted** : Validée
     * - **rejected** : Refusée
     * - **canceled** : Annulée par le collaborateur
     * - **inactive** : Supprimée (soft delete)
     * @param string|\DateTimeInterface $to Filtrer par date de fin (format ISO)
     * @param bool $today Si true, retourne uniquement les absences du jour en cours
     * @param string|list<string> $type Filtrer par type d'absence (peut être un tableau)
     * @param string $userTo Filtrer par utilisateur concerné
     * @param int $year Année pour le filtre calendrier. Requiert month.
     *
     * @throws APIException
     */
    public function list(
        string|\DateTimeInterface|null $from = null,
        ?array $inPeriod = null,
        int $limit = 20,
        ?int $month = null,
        string|array|null $positionTo = null,
        int $skip = 0,
        ?string $sort = null,
        string|\Wuro\Absences\AbsenceListParams\State|null $state = null,
        string|\DateTimeInterface|null $to = null,
        ?bool $today = null,
        string|array|null $type = null,
        ?string $userTo = null,
        ?int $year = null,
        ?RequestOptions $requestOptions = null,
    ): AbsenceListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'absence
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): AbsenceDeleteResponse;
}
