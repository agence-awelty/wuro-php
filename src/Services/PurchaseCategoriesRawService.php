<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\PurchaseCategories\PurchaseCategoryCreateParams;
use Wuro\PurchaseCategories\PurchaseCategoryGetResponse;
use Wuro\PurchaseCategories\PurchaseCategoryListResponse;
use Wuro\PurchaseCategories\PurchaseCategoryNewResponse;
use Wuro\PurchaseCategories\PurchaseCategoryUpdateParams;
use Wuro\PurchaseCategories\PurchaseCategoryUpdateParams\State;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PurchaseCategoriesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class PurchaseCategoriesRawService implements PurchaseCategoriesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   name: string, company?: string
     * }|PurchaseCategoryCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseCategoryNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PurchaseCategoryCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PurchaseCategoryCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'purchase-category',
            body: (object) $parsed,
            options: $options,
            convert: PurchaseCategoryNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les détails d'une catégorie d'achat spécifique.
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseCategoryGetResponse>
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
            path: ['purchase-category/%1$s', $uid],
            options: $requestOptions,
            convert: PurchaseCategoryGetResponse::class,
        );
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
     * @param array{
     *   name?: string, state?: State|value-of<State>
     * }|PurchaseCategoryUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PurchaseCategoryUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PurchaseCategoryUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['purchase-category/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: null,
        );
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
     * @return BaseResponse<PurchaseCategoryListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'purchase-categories',
            options: $requestOptions,
            convert: PurchaseCategoryListResponse::class,
        );
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
     * @return BaseResponse<mixed>
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
            path: ['purchase-category/%1$s', $uid],
            options: $requestOptions,
            convert: null,
        );
    }
}
