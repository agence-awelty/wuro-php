<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\AbsenceTypes\AbsenceTypeCreateParams\State;
use Wuro\AbsenceTypes\AbsenceTypeCreateParams\Type;
use Wuro\AbsenceTypes\AbsenceTypeDeleteResponse;
use Wuro\AbsenceTypes\AbsenceTypeGetResponse;
use Wuro\AbsenceTypes\AbsenceTypeListResponse;
use Wuro\AbsenceTypes\AbsenceTypeNewResponse;
use Wuro\AbsenceTypes\AbsenceTypeUpdateResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface AbsenceTypesContract
{
    /**
     * @api
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
    ): AbsenceTypeNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du type d'absence
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): AbsenceTypeGetResponse;

    /**
     * @api
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
    ): AbsenceTypeUpdateResponse;

    /**
     * @api
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
    ): AbsenceTypeListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du type d'absence
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): AbsenceTypeDeleteResponse;
}
