<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\AbsenceTypes\AbsenceTypeCreateParams\State;
use Wuro\AbsenceTypes\AbsenceTypeCreateParams\Type;
use Wuro\AbsenceTypes\AbsenceTypeDeleteResponse;
use Wuro\AbsenceTypes\AbsenceTypeGetResponse;
use Wuro\AbsenceTypes\AbsenceTypeListResponse;
use Wuro\AbsenceTypes\AbsenceTypeNewResponse;
use Wuro\AbsenceTypes\AbsenceTypeUpdateResponse;
use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\AbsenceTypesContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class AbsenceTypesService implements AbsenceTypesContract
{
    /**
     * @api
     */
    public AbsenceTypesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AbsenceTypesRawService($client);
    }

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
     * @param string $name Nom du type d'absence (obligatoire)
     * @param string $backgroundColor Couleur de fond pour l'affichage calendrier
     * @param string $backgroundColorRgb Couleur de fond en format RGB
     * @param string $color Couleur du texte
     * @param string $icon Icône Font Awesome (ex. "fa-umbrella-beach", "fa-briefcase-medical")
     * @param State|value-of<State> $state État initial (active par défaut)
     * @param Type|value-of<Type> $type Catégorie du type :
     * - **absence** : Congés, RTT, maladie (absence du collaborateur)
     * - **event** : Formation, réunion (présent mais non disponible)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $backgroundColor = null,
        ?string $backgroundColorRgb = null,
        ?string $color = null,
        ?string $icon = null,
        State|string $state = 'active',
        Type|string $type = 'absence',
        RequestOptions|array|null $requestOptions = null,
    ): AbsenceTypeNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'backgroundColor' => $backgroundColor,
                'backgroundColorRgb' => $backgroundColorRgb,
                'color' => $color,
                'icon' => $icon,
                'state' => $state,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): AbsenceTypeGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $backgroundColor Couleur de fond hexadécimale (ex. "#3498db")
     * @param string $backgroundColorRgb Couleur de fond en format RGB (ex. "52, 152, 219")
     * @param string $color Couleur du texte hexadécimale (ex. "#ffffff")
     * @param string $icon Icône Font Awesome ou autre (ex. "fa-umbrella-beach")
     * @param string $name Nom du type d'absence (ex. "Congés payés", "RTT", "Maladie")
     * @param \Wuro\AbsenceTypes\AbsenceTypeUpdateParams\State|value-of<\Wuro\AbsenceTypes\AbsenceTypeUpdateParams\State> $state État du type (inactive = masqué dans les choix)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $backgroundColor = null,
        ?string $backgroundColorRgb = null,
        ?string $color = null,
        ?string $icon = null,
        ?string $name = null,
        \Wuro\AbsenceTypes\AbsenceTypeUpdateParams\State|string|null $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): AbsenceTypeUpdateResponse {
        $params = Util::removeNulls(
            [
                'backgroundColor' => $backgroundColor,
                'backgroundColorRgb' => $backgroundColorRgb,
                'color' => $color,
                'icon' => $icon,
                'name' => $name,
                'state' => $state,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param int $limit Nombre maximum de types d'absence à retourner
     * @param int $skip Nombre de types d'absence à ignorer pour la pagination
     * @param string $sort Champ et direction de tri (ex. "name:1" pour tri alphabétique ascendant)
     * @param \Wuro\AbsenceTypes\AbsenceTypeListParams\State|value-of<\Wuro\AbsenceTypes\AbsenceTypeListParams\State> $state Filtrer par état (active/inactive)
     * @param \Wuro\AbsenceTypes\AbsenceTypeListParams\Type|value-of<\Wuro\AbsenceTypes\AbsenceTypeListParams\Type> $type Filtrer par catégorie (absence ou event)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $limit = 20,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\AbsenceTypes\AbsenceTypeListParams\State|string|null $state = null,
        \Wuro\AbsenceTypes\AbsenceTypeListParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): AbsenceTypeListResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): AbsenceTypeDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
