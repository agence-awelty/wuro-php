<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
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
 * @see Wuro\Services\ProductsService::importFromCsv()
 *
 * @phpstan-type ProductImportFromCsvParamsShape = array{file?: string|null}
 */
final class ProductImportFromCsvParams implements BaseModel
{
    /** @use SdkModel<ProductImportFromCsvParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Fichier CSV à importer.
     */
    #[Optional]
    public ?string $file;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $file = null): self
    {
        $self = new self;

        null !== $file && $self['file'] = $file;

        return $self;
    }

    /**
     * Fichier CSV à importer.
     */
    public function withFile(string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }
}
