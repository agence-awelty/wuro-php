<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\Products\ProductDeleteResponse;
use Wuro\Products\ProductGetResponse;
use Wuro\Products\ProductImportFromCsvResponse;
use Wuro\Products\ProductListParams\State;
use Wuro\Products\ProductListResponse;
use Wuro\Products\ProductNewResponse;
use Wuro\Products\ProductUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ProductsContract;
use Wuro\Services\Products\VariantService;

final class ProductsService implements ProductsContract
{
    /**
     * @api
     */
    public ProductsRawService $raw;

    /**
     * @api
     */
    public VariantService $variant;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ProductsRawService($client);
        $this->variant = new VariantService($client);
    }

    /**
     * @api
     *
     * Crée un nouveau produit dans le catalogue.
     *
     * ## Champs principaux
     *
     * - **name** : Nom du produit (obligatoire)
     * - **reference** : Référence/code article
     * - **price** : Prix unitaire HT
     * - **vat** : Taux de TVA (ex. 20, 10, 5.5)
     * - **unit** : Unité de vente (ex. "pièce", "heure", "kg")
     *
     * ## Catégories
     *
     * Vous pouvez associer le produit à une ou plusieurs catégories
     * en utilisant le champ `categories` (tableau d'IDs).
     *
     * ## Variantes
     *
     * Les produits peuvent avoir des variantes (taille, couleur, etc.)
     * qui sont gérées séparément via `/product-variants`.
     *
     * ## Événement déclenché
     *
     * Un événement `CREATE_PRODUCT` est émis après la création.
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
    ): ProductNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'analyticalCode' => $analyticalCode,
                'buyingPrice' => $buyingPrice,
                'category' => $category,
                'costPrice' => $costPrice,
                'description' => $description,
                'ecotax' => $ecotax,
                'electronic' => $electronic,
                'hasSpecifications' => $hasSpecifications,
                'hasStockManagement' => $hasStockManagement,
                'hasVariations' => $hasVariations,
                'isMarchandise' => $isMarchandise,
                'mandatoryMentions' => $mandatoryMentions,
                'options' => $options,
                'priceHt' => $priceHt,
                'reference' => $reference,
                'sku' => $sku,
                'specifications' => $specifications,
                'stock' => $stock,
                'suppliers' => $suppliers,
                'tva' => $tva,
                'tvaRate' => $tvaRate,
                'unit' => $unit,
                'urlExt' => $urlExt,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les informations détaillées d'un produit par son identifiant.
     *
     * Les informations incluent :
     * - Informations de base (nom, référence, description)
     * - Prix et TVA
     * - Unités de vente et conditionnement
     * - Catégorie(s) associée(s)
     * - Variantes si existantes
     *
     * @param string $uid Identifiant unique du produit
     * @param string $populate Relations à inclure (ex. "category", "variants")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null
    ): ProductGetResponse {
        $params = Util::removeNulls(['populate' => $populate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour les informations d'un produit existant.
     *
     * Vous pouvez modifier :
     * - Les informations de base (nom, référence, description)
     * - Les prix et TVA
     * - Les unités de vente
     * - Les catégories
     *
     * ## Événement déclenché
     *
     * Un événement `UPDATE_PRODUCT` est émis après la mise à jour.
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
    ): ProductUpdateResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'analyticalCode' => $analyticalCode,
                'buyingPrice' => $buyingPrice,
                'category' => $category,
                'costPrice' => $costPrice,
                'description' => $description,
                'ecotax' => $ecotax,
                'electronic' => $electronic,
                'hasSpecifications' => $hasSpecifications,
                'hasStockManagement' => $hasStockManagement,
                'hasVariations' => $hasVariations,
                'isMarchandise' => $isMarchandise,
                'mandatoryMentions' => $mandatoryMentions,
                'options' => $options,
                'priceHt' => $priceHt,
                'reference' => $reference,
                'sku' => $sku,
                'specifications' => $specifications,
                'stock' => $stock,
                'suppliers' => $suppliers,
                'tva' => $tva,
                'tvaRate' => $tvaRate,
                'unit' => $unit,
                'urlExt' => $urlExt,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère la liste de tous les produits du catalogue avec pagination, tri et recherche.
     *
     * ## Recherche
     *
     * Le paramètre `search` permet une recherche textuelle dans :
     * - Le nom du produit
     * - La référence
     * - La description
     *
     * ## Filtrage par catégorie
     *
     * Utilisez `category` pour filtrer par catégorie de produit.
     *
     * ## Tri
     *
     * Utilisez `sort` avec le format `champ:direction` où direction est 1 (asc) ou -1 (desc).
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
    ): ProductListResponse {
        $params = Util::removeNulls(
            [
                'category' => $category,
                'limit' => $limit,
                'search' => $search,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supprime un produit (soft delete).
     *
     * Le produit passe en état "inactive" et n'apparaît plus dans les listes standards.
     * Les documents existants (factures, devis) utilisant ce produit conservent les informations.
     *
     * ## Événement déclenché
     *
     * Un événement `DELETE_PRODUCT` est émis après la suppression.
     *
     * @param string $uid Identifiant unique du produit
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): ProductDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Importe une liste de produits à partir d'un fichier CSV.
     *
     * **Format du fichier CSV:**
     * - Le fichier doit être encodé en UTF-8
     * - La première ligne doit contenir les en-têtes des colonnes
     * - Séparateur de colonnes : point-virgule (;) ou virgule (,)
     *
     * **Colonnes supportées:**
     * - `name` : Nom du produit (obligatoire)
     * - `reference` : Référence produit
     * - `description` : Description
     * - `price_ht` : Prix unitaire HT
     * - `tva_rate` : Taux de TVA
     * - `unit` : Unité de mesure
     * - `category` : Nom de la catégorie
     * - `stock` : Quantité en stock
     *
     * **Comportement:**
     * - Les produits existants (basé sur la référence) sont mis à jour
     * - Les nouveaux produits sont créés
     * - Les catégories inexistantes sont créées automatiquement
     *
     * **Télécharger un modèle:**
     * - GET /files/products.csv pour obtenir un fichier modèle
     *
     * @param string $file Fichier CSV à importer
     *
     * @throws APIException
     */
    public function importFromCsv(
        ?string $file = null,
        ?RequestOptions $requestOptions = null
    ): ProductImportFromCsvResponse {
        $params = Util::removeNulls(['file' => $file]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->importFromCsv(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère la liste des variantes associées à un produit spécifique.
     *
     * @param string $uid Identifiant unique du produit parent
     *
     * @throws APIException
     */
    public function listVariants(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listVariants($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
