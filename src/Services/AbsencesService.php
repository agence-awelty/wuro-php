<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Absences\AbsenceCreateParams\FromMoment;
use Wuro\Absences\AbsenceCreateParams\State;
use Wuro\Absences\AbsenceCreateParams\ToMoment;
use Wuro\Absences\AbsenceDeleteResponse;
use Wuro\Absences\AbsenceGetResponse;
use Wuro\Absences\AbsenceListResponse;
use Wuro\Absences\AbsenceNewResponse;
use Wuro\Absences\AbsenceUpdateResponse;
use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\AbsencesContract;

final class AbsencesService implements AbsencesContract
{
    /**
     * @api
     */
    public AbsencesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AbsencesRawService($client);
    }

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
    ): AbsenceNewResponse {
        $params = Util::removeNulls(
            [
                'from' => $from,
                'to' => $to,
                'type' => $type,
                'fromMoment' => $fromMoment,
                'logs' => $logs,
                'positionTo' => $positionTo,
                'state' => $state,
                'toMoment' => $toMoment,
                'userTo' => $userTo,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $populate Relations à inclure (ex. "type", "positionTo", "userTo")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null
    ): AbsenceGetResponse {
        $params = Util::removeNulls(['populate' => $populate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
    ): AbsenceUpdateResponse {
        $params = Util::removeNulls(
            [
                'from' => $from,
                'fromMoment' => $fromMoment,
                'logs' => $logs,
                'state' => $state,
                'to' => $to,
                'toMoment' => $toMoment,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
    ): AbsenceListResponse {
        $params = Util::removeNulls(
            [
                'from' => $from,
                'inPeriod' => $inPeriod,
                'limit' => $limit,
                'month' => $month,
                'positionTo' => $positionTo,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
                'to' => $to,
                'today' => $today,
                'type' => $type,
                'userTo' => $userTo,
                'year' => $year,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): AbsenceDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
