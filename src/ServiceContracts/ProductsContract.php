<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Products\ProductCreateParams\Option;
use Wuro\Products\ProductCreateParams\Specifications;
use Wuro\Products\ProductCreateParams\Stock;
use Wuro\Products\ProductDeleteResponse;
use Wuro\Products\ProductGetResponse;
use Wuro\Products\ProductImportFromCsvResponse;
use Wuro\Products\ProductListParams\State;
use Wuro\Products\ProductListResponse;
use Wuro\Products\ProductNewResponse;
use Wuro\Products\ProductUpdateResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type OptionShape from \Wuro\Products\ProductCreateParams\Option
 * @phpstan-import-type SpecificationsShape from \Wuro\Products\ProductCreateParams\Specifications
 * @phpstan-import-type StockShape from \Wuro\Products\ProductCreateParams\Stock
 * @phpstan-import-type OptionShape from \Wuro\Products\ProductUpdateParams\Option as OptionShape1
 * @phpstan-import-type SpecificationsShape from \Wuro\Products\ProductUpdateParams\Specifications as SpecificationsShape1
 * @phpstan-import-type StockShape from \Wuro\Products\ProductUpdateParams\Stock as StockShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface ProductsContract
{
    /**
     * @api
     *
     * @param list<Option|OptionShape> $options
     * @param Specifications|SpecificationsShape $specifications
     * @param Stock|StockShape $stock
     * @param list<string> $suppliers
     * @param RequestOpts|null $requestOptions
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
        Specifications|array|null $specifications = null,
        Stock|array|null $stock = null,
        ?array $suppliers = null,
        ?string $tva = null,
        ?float $tvaRate = null,
        ?string $unit = null,
        ?string $urlExt = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProductNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param string $populate Relations à inclure (ex. "category", "variants")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProductGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param list<\Wuro\Products\ProductUpdateParams\Option|OptionShape1> $options
     * @param \Wuro\Products\ProductUpdateParams\Specifications|SpecificationsShape1 $specifications
     * @param \Wuro\Products\ProductUpdateParams\Stock|StockShape1 $stock
     * @param list<string> $suppliers
     * @param RequestOpts|null $requestOptions
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
        \Wuro\Products\ProductUpdateParams\Specifications|array|null $specifications = null,
        \Wuro\Products\ProductUpdateParams\Stock|array|null $stock = null,
        ?array $suppliers = null,
        ?string $tva = null,
        ?float $tvaRate = null,
        ?string $unit = null,
        ?string $urlExt = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProductUpdateResponse;

    /**
     * @api
     *
     * @param string $category Filtrer par catégorie de produit
     * @param int $limit Nombre maximum de produits à retourner
     * @param string $search Recherche textuelle dans nom, référence, description
     * @param int $skip Nombre de produits à ignorer (pagination)
     * @param string $sort Champ et direction de tri (ex. "name:1", "price:-1")
     * @param State|value-of<State> $state Filtrer par état (active = visible, inactive = archivé)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $category = null,
        int $limit = 20,
        ?string $search = null,
        int $skip = 0,
        ?string $sort = null,
        State|string|null $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProductListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): ProductDeleteResponse;

    /**
     * @api
     *
     * @param string $file Fichier CSV à importer
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function importFromCsv(
        ?string $file = null,
        RequestOptions|array|null $requestOptions = null
    ): ProductImportFromCsvResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit parent
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listVariants(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
