<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\PurchaseCategories\PurchaseCategoryGetResponse;
use Wuro\PurchaseCategories\PurchaseCategoryListResponse;
use Wuro\PurchaseCategories\PurchaseCategoryNewResponse;
use Wuro\PurchaseCategories\PurchaseCategoryUpdateParams\State;
use Wuro\RequestOptions;

interface PurchaseCategoriesContract
{
    /**
     * @api
     *
     * @param string $name Nom de la catégorie
     * @param string $company ID de l'entreprise (optionnel, défaut = entreprise courante)
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $company = null,
        ?RequestOptions $requestOptions = null,
    ): PurchaseCategoryNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): PurchaseCategoryGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     * @param string $name Nouveau nom de la catégorie
     * @param 'active'|'inactive'|State $state État de la catégorie
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $name = null,
        string|State|null $state = null,
        ?RequestOptions $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @throws APIException
     */
    public function list(
        ?RequestOptions $requestOptions = null
    ): PurchaseCategoryListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la catégorie
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;
}
