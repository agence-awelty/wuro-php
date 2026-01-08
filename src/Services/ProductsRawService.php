<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Products\ProductCreateParams;
use Wuro\Products\ProductCreateParams\Option;
use Wuro\Products\ProductCreateParams\Specifications;
use Wuro\Products\ProductCreateParams\Stock;
use Wuro\Products\ProductDeleteResponse;
use Wuro\Products\ProductGetResponse;
use Wuro\Products\ProductImportFromCsvParams;
use Wuro\Products\ProductImportFromCsvResponse;
use Wuro\Products\ProductListParams;
use Wuro\Products\ProductListParams\State;
use Wuro\Products\ProductListResponse;
use Wuro\Products\ProductNewResponse;
use Wuro\Products\ProductRetrieveParams;
use Wuro\Products\ProductUpdateParams;
use Wuro\Products\ProductUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\ProductsRawContract;

/**
 * @phpstan-import-type OptionShape from \Wuro\Products\ProductCreateParams\Option
 * @phpstan-import-type SpecificationsShape from \Wuro\Products\ProductCreateParams\Specifications
 * @phpstan-import-type StockShape from \Wuro\Products\ProductCreateParams\Stock
 * @phpstan-import-type OptionShape from \Wuro\Products\ProductUpdateParams\Option as OptionShape1
 * @phpstan-import-type SpecificationsShape from \Wuro\Products\ProductUpdateParams\Specifications as SpecificationsShape1
 * @phpstan-import-type StockShape from \Wuro\Products\ProductUpdateParams\Stock as StockShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class ProductsRawService implements ProductsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   name: string,
     *   analyticalCode?: string,
     *   buyingPrice?: float,
     *   category?: string,
     *   costPrice?: float,
     *   description?: string,
     *   ecotax?: float,
     *   electronic?: bool,
     *   hasSpecifications?: bool,
     *   hasStockManagement?: bool,
     *   hasVariations?: bool,
     *   isMarchandise?: bool,
     *   mandatoryMentions?: string,
     *   options?: list<Option|OptionShape>,
     *   priceHt?: float,
     *   reference?: string,
     *   sku?: string,
     *   specifications?: Specifications|SpecificationsShape,
     *   stock?: Stock|StockShape,
     *   suppliers?: list<string>,
     *   tva?: string,
     *   tvaRate?: float,
     *   unit?: string,
     *   urlExt?: string,
     * }|ProductCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ProductCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProductCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'product',
            body: (object) $parsed,
            options: $options,
            convert: ProductNewResponse::class,
        );
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
     * @param array{populate?: string}|ProductRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|ProductRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProductRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['product/%1$s', $uid],
            query: $parsed,
            options: $options,
            convert: ProductGetResponse::class,
        );
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
     * @param array{
     *   name: string,
     *   analyticalCode?: string,
     *   buyingPrice?: float,
     *   category?: string,
     *   costPrice?: float,
     *   description?: string,
     *   ecotax?: float,
     *   electronic?: bool,
     *   hasSpecifications?: bool,
     *   hasStockManagement?: bool,
     *   hasVariations?: bool,
     *   isMarchandise?: bool,
     *   mandatoryMentions?: string,
     *   options?: list<ProductUpdateParams\Option|OptionShape1>,
     *   priceHt?: float,
     *   reference?: string,
     *   sku?: string,
     *   specifications?: ProductUpdateParams\Specifications|SpecificationsShape1,
     *   stock?: ProductUpdateParams\Stock|StockShape1,
     *   suppliers?: list<string>,
     *   tva?: string,
     *   tvaRate?: float,
     *   unit?: string,
     *   urlExt?: string,
     * }|ProductUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|ProductUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProductUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['product/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: ProductUpdateResponse::class,
        );
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
     * @param array{
     *   category?: string,
     *   limit?: int,
     *   search?: string,
     *   skip?: int,
     *   sort?: string,
     *   state?: State|value-of<State>,
     * }|ProductListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ProductListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProductListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'products',
            query: $parsed,
            options: $options,
            convert: ProductListResponse::class,
        );
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductDeleteResponse>
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
            path: ['product/%1$s', $uid],
            options: $requestOptions,
            convert: ProductDeleteResponse::class,
        );
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
     * @param array{file?: string}|ProductImportFromCsvParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProductImportFromCsvResponse>
     *
     * @throws APIException
     */
    public function importFromCsv(
        array|ProductImportFromCsvParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProductImportFromCsvParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'products/csv',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: ProductImportFromCsvResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste des variantes associées à un produit spécifique.
     *
     * @param string $uid Identifiant unique du produit parent
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function listVariants(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['product/%1$s/variants', $uid],
            options: $requestOptions,
            convert: null,
        );
    }
}
