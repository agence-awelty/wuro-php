<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Products\ProductDeleteResponse;
use Wuro\Products\ProductGetResponse;
use Wuro\Products\ProductImportFromCsvResponse;
use Wuro\Products\ProductListParams\State;
use Wuro\Products\ProductListResponse;
use Wuro\Products\ProductNewResponse;
use Wuro\Products\ProductUpdateResponse;
use Wuro\RequestOptions;

interface ProductsContract
{
    /**
     * @api
     *
     * @param list<array{name?: string, values?: list<string>}> $options
     * @param array{
     *   depth?: float, height?: float, weight?: float, width?: float
     * } $specifications
     * @param array{
     *   forceSell?: bool, nbAlert?: float, nbMin?: float, nbStock?: float
     * } $stock
     * @param list<string> $suppliers
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $analyticalCode = null,
        ?float $buyingPrice = null,
        ?string $category = null,
        ?float $costPrice = null,
        ?string $description = null,
        ?float $ecotax = null,
        ?bool $electronic = null,
        ?bool $hasSpecifications = null,
        ?bool $hasStockManagement = null,
        ?bool $hasVariations = null,
        ?bool $isMarchandise = null,
        ?string $mandatoryMentions = null,
        ?array $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        ?array $specifications = null,
        ?array $stock = null,
        ?array $suppliers = null,
        ?string $tva = null,
        ?float $tvaRate = null,
        ?string $unit = null,
        ?string $urlExt = null,
        ?RequestOptions $requestOptions = null,
    ): ProductNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param string $populate Relations à inclure (ex. "category", "variants")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null,
    ): ProductGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param list<array{name?: string, values?: list<string>}> $options
     * @param array{
     *   depth?: float, height?: float, weight?: float, width?: float
     * } $specifications
     * @param array{
     *   forceSell?: bool, nbAlert?: float, nbMin?: float, nbStock?: float
     * } $stock
     * @param list<string> $suppliers
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        string $name,
        ?string $analyticalCode = null,
        ?float $buyingPrice = null,
        ?string $category = null,
        ?float $costPrice = null,
        ?string $description = null,
        ?float $ecotax = null,
        ?bool $electronic = null,
        ?bool $hasSpecifications = null,
        ?bool $hasStockManagement = null,
        ?bool $hasVariations = null,
        ?bool $isMarchandise = null,
        ?string $mandatoryMentions = null,
        ?array $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        ?array $specifications = null,
        ?array $stock = null,
        ?array $suppliers = null,
        ?string $tva = null,
        ?float $tvaRate = null,
        ?string $unit = null,
        ?string $urlExt = null,
        ?RequestOptions $requestOptions = null,
    ): ProductUpdateResponse;

    /**
     * @api
     *
     * @param string $category Filtrer par catégorie de produit
     * @param int $limit Nombre maximum de produits à retourner
     * @param string $search Recherche textuelle dans nom, référence, description
     * @param int $skip Nombre de produits à ignorer (pagination)
     * @param string $sort Champ et direction de tri (ex. "name:1", "price:-1")
     * @param 'active'|'inactive'|State $state Filtrer par état (active = visible, inactive = archivé)
     *
     * @throws APIException
     */
    public function list(
        ?string $category = null,
        int $limit = 20,
        ?string $search = null,
        int $skip = 0,
        ?string $sort = null,
        string|State|null $state = null,
        ?RequestOptions $requestOptions = null,
    ): ProductListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): ProductDeleteResponse;

    /**
     * @api
     *
     * @param string $file Fichier CSV à importer
     *
     * @throws APIException
     */
    public function importFromCsv(
        ?string $file = null,
        ?RequestOptions $requestOptions = null
    ): ProductImportFromCsvResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit parent
     *
     * @throws APIException
     */
    public function listVariants(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;
}
