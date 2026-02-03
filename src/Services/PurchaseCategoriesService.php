<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\PurchaseCategories\PurchaseCategoryGetResponse;
use Wuro\PurchaseCategories\PurchaseCategoryListResponse;
use Wuro\PurchaseCategories\PurchaseCategoryNewResponse;
use Wuro\PurchaseCategories\PurchaseCategoryUpdateParams\State;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PurchaseCategoriesContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class PurchaseCategoriesService implements PurchaseCategoriesContract
{
    /**
     * @api
     */
    public PurchaseCategoriesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PurchaseCategoriesRawService($client);
    }

    /**
     * @api
     *
     * Crée une nouvelle catégorie pour organiser les achats/dépenses.
     *
     * **Exemples de catégories:**
     * - Fournitures de bureau
     * - Services externes
     * - Frais de déplacement
     * - Abonnements
     *
     * **Champs requis:**
     * - `name` : Nom de la catégorie
     *
     * **Événement déclenché:** CREATE_PURCHASE_CATEGORY
     *
     * @param string $name Nom de la catégorie
     * @param string $company ID de l'entreprise (optionnel, défaut = entreprise courante)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $company = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseCategoryNewResponse {
        $params = Util::removeNulls(['name' => $name, 'company' => $company]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les détails d'une catégorie d'achat spécifique.
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PurchaseCategoryGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour une catégorie d'achat existante.
     *
     * **Modifications possibles:**
     * - Renommer la catégorie
     * - Activer/désactiver la catégorie
     *
     * **États:**
     * - `active` : Catégorie visible et utilisable
     * - `inactive` : Catégorie masquée
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param string $name Nouveau nom de la catégorie
     * @param State|value-of<State> $state État de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $name = null,
        State|string|null $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['name' => $name, 'state' => $state]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère la liste de toutes les catégories d'achats de l'entreprise.
     *
     * **Utilisation:**
     * - Organisation des dépenses par type (fournitures, services, etc.)
     * - Ventilation comptable des achats
     * - Rapports et statistiques par catégorie
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): PurchaseCategoryListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supprime une catégorie d'achat.
     *
     * **Attention:**
     * - Les achats associés à cette catégorie ne seront plus catégorisés
     * - Cette opération est irréversible
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
