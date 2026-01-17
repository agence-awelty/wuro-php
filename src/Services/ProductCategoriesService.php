<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\ProductCategories\ProductCategory;
use Wuro\ProductCategories\ProductCategoryListResponse;
use Wuro\ProductCategories\ProductCategoryUpdateParams\State;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ProductCategoriesContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class ProductCategoriesService implements ProductCategoriesContract
{
    /**
     * @api
     */
    public ProductCategoriesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ProductCategoriesRawService($client);
    }

    /**
     * @api
     *
     * Crée une nouvelle catégorie pour organiser les produits.
     *
     * **Champs requis:**
     * - `name` : Nom de la catégorie
     *
     * **Événement déclenché:** CREATE_PRODUCT_CATEGORY
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
    ): ProductCategory {
        $params = Util::removeNulls(['name' => $name, 'company' => $company]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les détails d'une catégorie de produit spécifique.
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): ProductCategory {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour une catégorie de produit existante.
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
     * Récupère la liste de toutes les catégories de produits de l'entreprise.
     *
     * **Utilisation:**
     * - Organisation du catalogue produits
     * - Filtrage des produits par catégorie
     * - Rapports et statistiques par catégorie
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): ProductCategoryListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supprime une catégorie de produit.
     *
     * **Attention:**
     * - Les produits associés à cette catégorie ne seront plus catégorisés
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
